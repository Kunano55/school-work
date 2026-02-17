document.addEventListener('DOMContentLoaded', fetchAdminCats);

async function fetchAdminCats() {
    const tableBody = document.getElementById('adminCatTable');
    
    try {
        const response = await fetch('api/cat_breeds.php'); // เรียก API GET
        const data = await response.json();

        tableBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach(cat => {
                // รูปภาพจะได้รับ Path ที่ API จัดการให้แล้ว (../../lab8/uploads/...)
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
                fetchAdminCats(); // โหลดตารางใหม่
            } else {
                alert('ไม่สามารถลบข้อมูลได้: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting:', error);
            alert('เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }
}