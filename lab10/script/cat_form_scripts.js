document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const catId = urlParams.get('id');
    const form = document.getElementById('catForm');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    // 1. ตรวจสอบว่าเป็นโหมดแก้ไขหรือไม่
    if (catId) {
        document.getElementById('formTitle').innerText = 'แก้ไขข้อมูลสายพันธุ์แมว';
        loadCatData(catId);
    }

    // 2. แสดงตัวอย่างรูปภาพเมื่อเลือกไฟล์
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // 3. จัดการการบันทึกข้อมูล (Submit)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        
        // ถ้าเป็นโหมดแก้ไข (มี id) ให้ใช้ PUT แต่เนื่องจากส่งไฟล์ภาพ 
        // เราจะส่งแบบ POST โดยระบุ id เพื่อให้ API รู้ (หรือปรับ API ให้รับ Multipart ใน PUT)
        const isEdit = document.getElementById('cat_id').value;
        const apiUrl = 'api/cat_breeds.php';

        try {
            // ในที่นี้ใช้ POST ทั้งเพิ่มและแก้ โดย API จะแยกแยะจากฟิลด์ ID หรือ Method
            // ถ้าส่ง id ไปด้วย API ต้องจัดการ UPDATE แทน INSERT
            const response = await fetch(apiUrl, {
                method: 'POST', 
                body: formData
            });

            const result = await response.json();
            if (result.status === 201 || result.status === 200) {
                alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                window.location.href = 'cat_back_end.html';
            } else {
                alert('เกิดข้อผิดพลาด: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('ไม่สามารถเชื่อมต่อ API ได้');
        }
    });
});

async function loadCatData(id) {
    try {
        const response = await fetch('api/cat_breeds.php');
        const data = await response.json();
        const cat = data.find(item => item.id == id);

        if (cat) {
            document.getElementById('cat_id').value = cat.id;
            document.getElementById('name_th').value = cat.name_th;
            document.getElementById('name_en').value = cat.name_en;
            document.getElementById('description').value = cat.description;
            document.getElementById('characteristics').value = cat.characteristics;
            document.getElementById('care_instructions').value = cat.care_instructions;
            document.getElementById('is_visible').value = cat.is_visible;
            
            if (cat.image_url) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = cat.image_url;
                imagePreview.style.display = 'block';
                document.getElementById('existing_image').value = cat.image_url.replace('../../lab8/', '');
            }
        }
    } catch (error) {
        console.error('Error loading data:', error);
    }
}