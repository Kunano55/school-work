<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบคำนวณส่วนลด</title>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; width: 100%; max-width: 450px; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        input[type="number"], select { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; outline: none;
        }
        button { 
            width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;
        }
        .result-box { margin-top: 25px; padding: 20px; border-radius: 10px; background-color: #f8f9fa; border-left: 6px solid #007bff; }
        .price { font-size: 24px; color: #28a745; font-weight: bold; }
        .suggestion { margin-top: 15px; font-size: 0.9em; color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px; }
        .error { color: #721c24; background: #f8d7da; padding: 10px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <h2>💰 คำนวณส่วนลด</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>ยอดซื้อสินค้า (บาท)</label>
            <input type="number" step="0.01" name="amount" required 
                   value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label>สถานะลูกค้า</label>
            <select name="is_member">
                <option value="0" <?php echo (isset($_POST['is_member']) && $_POST['is_member'] == '0') ? 'selected' : ''; ?>>ลูกค้าทั่วไป</option>
                <option value="1" <?php echo (isset($_POST['is_member']) && $_POST['is_member'] == '1') ? 'selected' : ''; ?>>สมาชิก (Member)</option>
            </select>
        </div>
        
        <button type="submit">ประมวลผล</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount = floatval($_POST['amount']);
        $isMember = $_POST['is_member'];

        if ($amount < 0) {
            echo "<div class='error' style='margin-top:20px;'>กรุณาระบุยอดซื้อที่มากกว่า 0</div>";
        } else {
            $level = "ทั่วไป"; $rate = 0; $next = 0; $nextRate = 0;

            if ($amount >= 5000) { $level = "Platinum"; $rate = 20; }
            elseif ($amount >= 3000) { $level = "Gold"; $rate = 15; $next = 5000; $nextRate = 20; }
            elseif ($amount >= 1000) { $level = "Silver"; $rate = 10; $next = 3000; $nextRate = 15; }
            elseif ($amount >= 500) { $level = "Bronze"; $rate = 5; $next = 1000; $nextRate = 10; }
            else { $next = 500; $nextRate = 5; }

            $memberAddon = ($isMember == 1 && $amount >= 500) ? 5 : 0;
            $totalRate = $rate + $memberAddon;
            $discount = ($amount * $totalRate) / 100;
            $total = $amount - $discount;

            echo "<div class='result-box'>";
            echo "ยอดซื้อ: " . number_format($amount, 2) . " บาท<br>";
            
            if ($totalRate > 0) {
                echo "ระดับ: <span style='color:#007bff; font-weight:bold;'>$level</span><br>";
                if ($memberAddon > 0) echo "ส่วนลดสมาชิก: +5%<br>";
                echo "ส่วนลดรวม: $totalRate% (" . number_format($discount, 2) . " บาท)<br>";
            } else {
                echo "ระดับ: ทั่วไป (ไม่มีส่วนลด)<br>";
            }
            
            echo "<hr style='border: 0; border-top: 1px solid #ddd;'>";
            echo "ยอดสุทธิที่ต้องจ่าย:<br>";
            echo "<span class='price'>" . number_format($total, 2) . " บาท</span>";
            echo "</div>";

            if ($next > 0) {
                $diff = $next - $amount;
                echo "<div class='suggestion'>💡 ช้อปเพิ่มอีก <b>" . number_format($diff, 2) . " บาท</b> เพื่อรับส่วนลดเป็น $nextRate%</div>";
            }
        }
    }
    ?>
</div>

</body>
</html>