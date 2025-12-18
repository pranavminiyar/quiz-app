<footer class="footer">
  Quiz App © 2025
</footer>

<script>
const toggle = document.getElementById("darkToggle");

if (toggle) {
  toggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");
    localStorage.setItem(
      "darkMode",
      document.body.classList.contains("dark")
    );
  });
}

if (localStorage.getItem("darkMode") === "true") {
  document.body.classList.add("dark");
}
</script>

</body>
</html>
