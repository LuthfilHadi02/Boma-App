const rosterData = [
    { nama: "Fahri", posisi: "Anchor", nomor: "04", tim: "putra", img: "https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Dika", posisi: "Flank", nomor: "11", tim: "putra", img: "https://images.unsplash.com/photo-1529900965600-700940f81d4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Reza", posisi: "Pivot", nomor: "09", tim: "putra", img: "https://images.unsplash.com/photo-1543351611-58f69d7c1781?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Andi", posisi: "Goalkeeper (GK)", nomor: "01", tim: "putra", img: "https://images.unsplash.com/photo-1518622358385-8ea7d0794bf6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    
    { nama: "Sinta", posisi: "Anchor", nomor: "03", tim: "putri", img: "https://images.unsplash.com/photo-1526232761682-d26e03ac148e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Putri", posisi: "Flank", nomor: "07", tim: "putri", img: "https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" },
    { nama: "Rini", posisi: "Goalkeeper (GK)", nomor: "20", tim: "putri", img: "https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" }
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