document.addEventListener("DOMContentLoaded", function () {

    const completedYears = parseFloat(
        document.getElementById("completedYears").textContent
    ) || 0;

    const totalYears = parseFloat(
        document.getElementById("totalYears").textContent
    ) || 6;

    const progressBar = document.getElementById("yearProgressBar");

    let percentage = (completedYears / totalYears) * 100;

    // Prevent going below 0 or above 100
    percentage = Math.max(0, Math.min(percentage, 100));

    // Small delay makes the filling animation visible
    setTimeout(() => {
        progressBar.style.width = percentage + "%";
    }, 200);
});