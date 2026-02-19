document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const loginBtn = document.getElementById('loginBtn');
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // เปลี่ยนสถานะปุ่มขณะกำลังตรวจสอบ
    const originalBtnText = loginBtn.innerText;
    loginBtn.innerText = 'กำลังตรวจสอบ...';
    loginBtn.disabled = true;

    try {
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });

        const result = await response.json();

        if (result.status === 200) {
            window.location.href = 'cat_back_end.html';
        } else {
            alert(result.message || 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            loginBtn.innerText = originalBtnText;
            loginBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
        loginBtn.innerText = originalBtnText;
        loginBtn.disabled = false;
    }
});