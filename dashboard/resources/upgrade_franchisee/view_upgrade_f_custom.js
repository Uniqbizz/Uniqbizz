//franchisee upgrade History Details
function upgradeHistoryPage(id,ref){
    window.location.href='upgrade_franchisee_history.php?id='+id+'&sub_f_id='+ref;
}

$('#upgardeHistoryTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    responsive: false,   // IMPORTANT: disable DataTables responsive
    autoWidth: false,    // IMPORTANT: don’t let DataTables guess widths
    scrollX: true 
});
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}