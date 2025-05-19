document.addEventListener("DOMContentLoaded", function () {
    // start delete confirmation
    document.querySelectorAll(".show_confirm").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            var url = this.getAttribute("href");
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        });
    });
    // end delete confirmation

    // start auto dismiss
    function addAutoDismiss(alert) {
        if (!alert.dataset.dismissed) {
            setTimeout(function () {
                alert.style.display = "none";
            }, 5000);

            const closeBtn = alert.querySelector("button");
            if (closeBtn) {
                closeBtn.addEventListener("click", function () {
                    alert.style.display = "none";
                });
            }

            alert.dataset.dismissed = "true";
        }
    }

    document.querySelectorAll(".auto-dismiss").forEach(addAutoDismiss);

    const observer = new MutationObserver(function (mutationsList) {
        for (const mutation of mutationsList) {
            mutation.addedNodes.forEach((node) => {
                if (
                    node.nodeType === 1 &&
                    node.classList.contains("auto-dismiss")
                ) {
                    addAutoDismiss(node);
                }
            });
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
    // end auto dismiss

    // start reset
    const filterForms = document.querySelectorAll(".form");

    filterForms.forEach(function (form) {
        const clearButton = form.querySelector(".clear-btn");

        if (clearButton) {
            clearButton.addEventListener("click", function (e) {
                e.preventDefault();
                form.reset();

                const select2Elements = form.querySelectorAll(
                    '[data-control="select2"]'
                );
                select2Elements.forEach(function (select) {
                    $(select).val(null).trigger("change");
                });

                select2Elements.forEach(function (select) {
                    $(select).select2({
                        placeholder:
                            $(select).data("placeholder") || "Select an option",
                    });
                });
            });
        }
    });
    // end reset
});
