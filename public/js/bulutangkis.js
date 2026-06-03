const rosterData = [
    { nama: "Arga Kusuma", posisi: "Tunggal Putra (MS)", tim: "putra", img: "https://images.unsplash.com/photo-1621571520163-95ba1a646c07?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Hendra", posisi: "Ganda Putra (MD)", tim: "putra", img: "https://images.unsplash.com/photo-1599839619722-39751411ea63?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Ahsan", posisi: "Ganda Putra (MD)", tim: "putra", img: "https://images.unsplash.com/photo-1589801258579-18e091f4ca26?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Tantowi", posisi: "Ganda Campuran (XD)", tim: "putra", img: "https://images.unsplash.com/photo-1611340156976-78eec86b5cb5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    
    { nama: "Gregoria", posisi: "Tunggal Putri (WS)", tim: "putri", img: "https://images.unsplash.com/photo-1530325492471-a47781b0a6da?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Greysia", posisi: "Ganda Putri (WD)", tim: "putri", img: "https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Apriyani", posisi: "Ganda Putri (WD)", tim: "putri", img: "https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" }
];

function renderRoster(timFilter) {
    const grid = document.getElementById('rosterGrid');
    grid.innerHTML = ''; 

    const filteredRoster = rosterData.filter(player => player.tim === timFilter);

    filteredRoster.forEach(player => {
        const card = `
            <div class="player-card">
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