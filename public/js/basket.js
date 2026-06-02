const rosterData = [
    { nama: "Juan Diego", posisi: "Point Guard (PG)", nomor: "07", tim: "putra", img: "https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Bima Arya", posisi: "Shooting Guard (SG)", nomor: "12", tim: "putra", img: "https://images.unsplash.com/photo-1515523110800-9415d13b84a8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Rizky Fadhil", posisi: "Small Forward (SF)", nomor: "23", tim: "putra", img: "https://images.unsplash.com/photo-1574623452334-1e0ac0b38b4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Kevin Sanjaya", posisi: "Center (C)", nomor: "15", tim: "putra", img: "https://images.unsplash.com/photo-1518063319789-7217e6706b04?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    
    { nama: "Rizka Aulia", posisi: "Point Guard (PG)", nomor: "04", tim: "putri", img: "https://images.unsplash.com/photo-1553531384-cc64ac80f931?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Nadia Shafira", posisi: "Shooting Guard (SG)", nomor: "09", tim: "putri", img: "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Sarah Wijaya", posisi: "Center (C)", nomor: "33", tim: "putri", img: "https://images.unsplash.com/photo-1574623452334-1e0ac0b38b4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" }
];

function renderRoster(timFilter) {
    const grid = document.getElementById('rosterGrid');
    grid.innerHTML = ''; 

    const filteredRoster = rosterData.filter(player => player.tim === timFilter);

    filteredRoster.forEach(player => {
        const card = `
            <div class="player-card">
                <div class="player-number">${player.nomor}</div>
                <img src="${player.img}" alt="${player.nama}" class="player-img">
                <div class="player-info">
                    <h3 class="player-name">${player.nama}</h3>
                    <p class="player-pos">${player.posisi}</p>
                </div>
            </div>
        `;
        grid.innerHTML += card;
    });
}

function filterRoster(tim) {
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    event.target.classList.add('active');
    renderRoster(tim);
}

document.addEventListener('DOMContentLoaded', () => {
    renderRoster('putra');
});