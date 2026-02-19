// 1. เรียกใช้งาน checkAuth ทันทีเมื่อโหลดหน้าเว็บ
document.addEventListener('DOMContentLoaded', async () => {
    // ซ่อนเนื้อหาหน้าเว็บไว้ก่อนจนกว่าจะเช็คสิทธิ์เสร็จ (ป้องกันหน้ากะพริบ)
    document.body.style.opacity = '0'; 
    
    const isAuthenticated = await checkAuth();
    
    if (isAuthenticated) {
        document.body.style.opacity = '1'; // แสดงเนื้อหา
        fetchAdminCats(); // โหลดข้อมูลแมวตามปกติ
    }
});

// ฟังก์ชันสำหรับตรวจสอบ Session จาก Server
async function checkAuth() {
    try {
        const response = await fetch('api/check_session.php');
        const result = await response.json();

        if (result.status !== 200) {
            // ถ้าไม่ได้ Login ให้ส่งกลับไปหน้า login.html
            window.location.href = 'login.html';
            return false;
        }
        return true;
    } catch (error) {
        console.error('Auth Error:', error);
        window.location.href = 'login.html';
        return false;
    }
}

// ฟังก์ชันดึงข้อมูลแมว (คงเดิมจากที่คุณเขียนไว้ แต่เพิ่มความปลอดภัย)
async function fetchAdminCats() {
    const tableBody = document.getElementById('adminCatTable');
    
    try {
        const response = await fetch('api/cat_breeds.php'); // API นี้ต้องใส่ session_start() ด้วย
        if (response.status === 401) {
            window.location.href = 'login.html';
            return;
        }
        
        const data = await response.json();
        tableBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach(cat => {
                const imageUrl = cat.image_url || 'https://via.placeholder.com/80x60?text=No+Img';
                const statusText = cat.is_visible == 1 
                    ? '<span class="badge bg-success">แสดง</span>' 
                    : '<span class="badge bg-secondary">ซ่อน</span>';

                tableBody.innerHTML += `
                    <tr>
                        <td><img src="${imageUrl}" class="img-preview"></td>
                        <td>
                            <strong>${cat.name_th}</strong><br>
                            <small class="text-muted">${cat.name_en}</small>
                        </td>
                        <td>${statusText}</td>
                        <td>
                            <a href="cat_form.html?id=${cat.id}" class="btn btn-warning btn-action">แก้ไข</a>
                            <button onclick="deleteCat(${cat.id})" class="btn btn-danger btn-action">ลบ</button>
                        </td>
                    </tr>
                `;
            });
        } else {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center">ไม่พบข้อมูล</td></tr>';
        }
    } catch (error) {
        console.error('Error:', error);
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">เกิดข้อผิดพลาดในการเชื่อมต่อ API</td></tr>';
    }
}

// ฟังก์ชันลบข้อมูล (คงเดิม)
async function deleteCat(id) {
    if (confirm('ยืนยันที่จะลบข้อมูลนี้ใช่ไหม?')) {
        try {
            const response = await fetch('api/cat_breeds.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            const result = await response.json();
            if (result.status === 200) {
                alert('ลบข้อมูลสำเร็จ');
                fetchAdminCats(); 
            } else {
                alert('ไม่สามารถลบข้อมูลได้: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting:', error);
            alert('เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }
}

// ฟังก์ชันสำหรับ Logout (ผูกกับปุ่มใน HTML ได้เลย)
async function logout() {
    if (confirm('ยืนยันการออกจากระบบ?')) {
        try {
            await fetch('api/login.php?action=logout'); // เรียก API เพื่อทำลาย session
            window.location.href = 'cat_front_end.html';
        } catch (error) {
            alert('เกิดข้อผิดพลาดในการ Logout');
        }
    }
}