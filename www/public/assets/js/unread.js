document.addEventListener("DOMContentLoaded", function() {
    // Appel de l'API dès que la page est prête
    fetch('unread-count')
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            const badge = document.getElementById('unread');
            badge.innerText = data.unread_messages_count;          
            
        })
        .catch(error => console.error("Impossible de charger le compteur :", error));
});
