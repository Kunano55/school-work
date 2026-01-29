<?php
include 'db_connect.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM CatBreeds WHERE is_visible = 1";
if (!empty($search)) {
    $sql .= " AND (name_th LIKE ? OR name_en LIKE ?)";
}

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("ss", $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Lovers Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #fdfbfb; }
        .hero-banner { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1519052537078-e6302a4968d4?q=80&w=2070&auto=format&fit=crop');
            background-size: cover; background-position: center; color: white; padding: 100px 0; margin-bottom: 50px;
        }
        .search-container { max-width: 600px; margin: -35px auto 0; background: white; padding: 10px; border-radius: 50px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .cat-card { border: none; border-radius: 20px; transition: 0.3s; overflow: hidden; }
        .cat-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .cat-img { height: 200px; object-fit: cover; }
        .badge-cat { background-color: #ff8e8e; color: white; border-radius: 10px; padding: 5px 15px; font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="hero-banner text-center">
    <div class="container">
        <h1 class="display-3 fw-bold">ทำความรู้จักเจ้าเหมียว</h1>
        <p class="fs-4">รวบรวมข้อมูลสายพันธุ์แมวที่คุณอาจจะยังไม่เคยรู้</p>
    </div>
</div>

<div class="container">
    <div class="search-container mb-5">
        <form action="cat_front_end.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control border-0 bg-transparent ps-4" 
                   placeholder="พิมพ์ชื่อแมว..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary rounded-pill px-4">ค้นหา</button>
        </form>
    </div>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 cat-card shadow-sm">
                        <?php $image = !empty($row['image_url']) ? $row['image_url'] : 'https://via.placeholder.com/400x300?text=No+Photo'; ?>
                        <img src="<?php echo $image; ?>" class="card-img-top cat-img">
                        <div class="card-body">
                            <span class="badge-cat mb-2 d-inline-block"><?php echo $row['name_en']; ?></span>
                            <h5 class="card-title fw-bold"><?php echo $row['name_th']; ?></h5>
                            <p class="card-text text-muted small"><?php echo mb_substr($row['description'], 0, 80) . '...'; ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <button class="btn btn-outline-dark btn-sm rounded-pill w-100" 
                                    onclick="showDetails('<?php echo $row['name_th']; ?>', '<?php echo addslashes($row['characteristics']); ?>', '<?php echo addslashes($row['care_instructions']); ?>')">
                                ดูข้อมูลเพิ่มเติม
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">ขออภัย ไม่พบสายพันธุ์ที่คุณค้นหา...</p>
                <a href="cat_front_end.php" class="text-primary text-decoration-none">กลับไปหน้าแรก</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="catModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 20px;">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="modalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <h6><strong>ลักษณะเด่น:</strong></h6>
        <p id="modalChar" class="text-muted"></p>
        <hr>
        <h6><strong>การดูแลรักษา:</strong></h6>
        <p id="modalCare" class="text-muted"></p>
      </div>
    </div>
  </div>
</div>

<footer class="mt-5 py-4 bg-light text-center border-top">
    <small class="text-muted">CAT CATALOGUE &copy; 2026 - IT67040233141</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showDetails(title, char, care) {
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('modalChar').innerText = char || 'ไม่มีข้อมูล';
        document.getElementById('modalCare').innerText = care || 'ไม่มีข้อมูล';
        var myModal = new bootstrap.Modal(document.getElementById('catModal'));
        myModal.show();
    }
</script>
</body>
</html>