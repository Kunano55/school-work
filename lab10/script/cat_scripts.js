// ดึงข้อมูลเมื่อโหลดหน้าเว็บ
document.addEventListener('DOMContentLoaded', fetchCats);

async function fetchCats() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const displayArea = document.getElementById('catDisplay');
    
    try {
        // เรียกใช้งาน API (ดึงข้อมูลจาก cat_breeds.php)
        const response = await fetch('api/cat_breeds.php');
        const data = await response.json();

        // กรองข้อมูลตามการค้นหา และแสดงเฉพาะที่ is_visible = 1
        const filteredData = data.filter(cat => {
            const matchesSearch = cat.name_th.toLowerCase().includes(searchTerm) || 
                                cat.name_en.toLowerCase().includes(searchTerm);
            return cat.is_visible == 1 && matchesSearch;
        });

        displayArea.innerHTML = '';

        if (filteredData.length > 0) {
            filteredData.forEach(cat => {
                const imageUrl = cat.image_url || 'https://via.placeholder.com/400x300?text=No+Photo';
                const description = cat.description.substring(0, 80) + '...';
                
                // ใช้ Template Literals เพื่อส่งค่าไปยัง modal (รองรับ Single/Double Quote ในข้อความ)
                displayArea.innerHTML += `
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card cat-card shadow-sm">
                            <img src="${imageUrl}" class="card-img-top cat-img">
                            <div class="card-body">
                                <span class="badge-cat mb-2 d-inline-block">${cat.name_en}</span>
                                <h5 class="card-title fw-bold">${cat.name_th}</h5>
                                <p class="card-text text-muted small">${description}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-dark btn-sm rounded-pill w-100" 
                                        onclick="showDetails(\`${cat.name_th}\`, \`${cat.characteristics}\`, \`${cat.care_instructions}\`)">
                                    ดูข้อมูลเพิ่มเติม
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            displayArea.innerHTML = `
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">ขออภัย ไม่พบสายพันธุ์ที่คุณค้นหา...</p>
                    <button onclick="resetSearch()" class="btn btn-link text-decoration-none">กลับไปหน้าแรก</button>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        displayArea.innerHTML = '<p class="text-center text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</p>';
    }
}

function resetSearch() {
    document.getElementById('searchInput').value = '';
    fetchCats();
}

function showDetails(title, char, care) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalChar').innerText = char || 'ไม่มีข้อมูล';
    document.getElementById('modalCare').innerText = care || 'ไม่มีข้อมูล';
    var myModal = new bootstrap.Modal(document.getElementById('catModal'));
    myModal.show();
}