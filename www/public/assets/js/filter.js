// assets/js/search-filter.js

document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.getElementById("search-bar");
    const cards = document.querySelectorAll(".book-card");
    const noResultsMessage = document.getElementById("no-results");

    if (!searchBar) return;

    searchBar.addEventListener("input", (e) => {
        const searchValue = e.target.value.toLowerCase().trim();

        cards.forEach((card) => {
            const title = card.getAttribute("data-title") || "";
            const author = card.getAttribute("data-author") || "";
            const user = card.getAttribute("data-pseudo") || "";

            const matchesTitle = title.includes(searchValue);
            const matchesAuthor = author.includes(searchValue);
            const matchesUser = user.includes(searchValue);

            if (matchesTitle || matchesAuthor || matchesUser) {
                card.classList.remove("hidden");
                card.classList.add("flex");
            } else {
                card.classList.remove("flex");
                card.classList.add("hidden");
            }
        });

        // Gestion optionnelle du message "Aucun résultat"
        if (noResultsMessage) {
            const hiddenCards = document.querySelectorAll(".book-card.hidden").length;
            if (hiddenCards === cards.length) {
                noResultsMessage.classList.remove("hidden");
                noResultsMessage.classList.add("flex");
            } else {
                noResultsMessage.classList.remove("flex");
                noResultsMessage.classList.add("hidden");
            }
        }
    });
});