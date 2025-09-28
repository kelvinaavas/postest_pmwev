document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.getElementById("darkModeToggle");
  const body = document.body;

  toggleButton.addEventListener("click", () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")) {
      toggleButton.textContent = "☀️ Light Mode";
    } else {
      toggleButton.textContent = "🌙 Dark Mode";
    }
  });
});