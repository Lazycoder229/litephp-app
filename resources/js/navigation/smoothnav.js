export function initSmoothNav() {
  document.addEventListener("click", function (e) {
    const link = e.target.closest("[data-ajax-link]");
    if (!link) return;

    e.preventDefault();
    const url = link.href;

    document.querySelectorAll("[data-ajax-link]").forEach((a) => {
      a.classList.remove("text-gray-900", "font-medium");
      a.classList.add("text-gray-500");
    });
    link.classList.add("text-gray-900", "font-medium");
    link.classList.remove("text-gray-500");

    const main = document.querySelector("main");

    // Close sidebar FIRST before swapping content
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebar-backdrop");
    const isMobileSidebarOpen =
      sidebar && !sidebar.classList.contains("-translate-x-full");

    if (window.innerWidth < 768 && isMobileSidebarOpen) {
      sidebar.classList.add("-translate-x-full");
      backdrop.classList.add("hidden");
    }

    main.classList.add("opacity-0");

    const doFetch = () => {
      fetch(url)
        .then((res) => {
          // throw so catch handles error pages
          if (!res.ok) throw new Error(res.status);
          return res.text();
        })
        .then((html) => {
          if (!html) return;

          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");
          const newMain = doc.querySelector("main");

          //  fix 2 — no <main> found, full reload
          if (!newMain) {
            window.location.href = url;
            return;
          }

          main.innerHTML = newMain.innerHTML;
          main.scrollTop = 0;

          window.history.pushState({}, doc.title, url);
          document.title = doc.title;

          // reinit page-level JS after swap
          if (typeof window.initPage === "function") {
            window.initPage();
          }

          requestAnimationFrame(() => main.classList.remove("opacity-0"));
        })
        .catch(() => {
          // fallback — full reload if totally broken or HTTP error
          window.location.href = url;
        });
    };

    doFetch();
  });

  window.addEventListener("popstate", () => {
    const main = document.querySelector("main");
    main.classList.add("opacity-0");
    fetch(location.href)
      .then((res) => {
        if (!res.ok) throw new Error(res.status);
        return res.text();
      })
      .then((html) => {
        const doc = new DOMParser().parseFromString(html, "text/html");
        const newMain = doc.querySelector("main");
        if (!newMain) {
          window.location.href = location.href;
          return;
        }
        main.innerHTML = newMain.innerHTML;
        document.title = doc.title;

        if (typeof window.initPage === "function") {
          window.initPage();
        }

        requestAnimationFrame(() => main.classList.remove("opacity-0"));
      })
      .catch(() => {
        window.location.href = location.href;
      });
  });
}

export function bodyGlitch() {
  document.body.style.transition = "opacity 0.15s ease";
  document.body.style.opacity = "0";
  requestAnimationFrame(() => {
    document.body.style.opacity = "1";
  });
}