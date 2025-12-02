console.log("Menu UI Loaded");

// Example event
document.querySelectorAll(".detail-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        alert("Detail berasal dari database nanti 😎");
    });
});
