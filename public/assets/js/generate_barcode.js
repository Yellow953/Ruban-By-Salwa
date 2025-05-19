document.addEventListener("DOMContentLoaded", function () {
    const generateBtn = document.getElementById("generate_barcodes");
    const printBtn = document.getElementById("print_barcodes");
    const previewBtn = document.getElementById("preview_barcodes");
    const barcodesContainer = document.getElementById("barcodes_container");
    const barcodeList = document.getElementById("barcode_list");
    const barcodeIcon = document.querySelector(".barcode-icon-container");
    const labelSheet = document.getElementById("label_sheet");
    const previewSheet = document.getElementById("preview_sheet");
    const printContainer = document.getElementById("print_container");
    const previewModal = new bootstrap.Modal(
        document.getElementById("previewModal")
    );

    barcodeIcon.addEventListener("click", function () {
        generateBtn.click();
    });

    generateBtn.addEventListener("click", generateBarcodes);
    printBtn.addEventListener("click", printBarcodes);
    previewBtn.addEventListener("click", previewBarcodes);
    document
        .getElementById("print_from_preview")
        .addEventListener("click", printFromPreview);

    function generateBarcodes() {
        const prefix = document.getElementById("barcode_prefix").value;
        const quantity =
            parseInt(document.getElementById("barcode_quantity").value) || 10;
        const barcodeType = document.getElementById("barcode_type").value;
        const barcodeSize =
            parseInt(document.getElementById("barcode_size").value) || 2;

        const labelWidth = document.getElementById("label_width").value || 50;
        const labelHeight = document.getElementById("label_height").value || 20;
        const labelsPerRow =
            document.getElementById("labels_per_row").value || 4;

        document.documentElement.style.setProperty("--label-width", labelWidth);
        document.documentElement.style.setProperty(
            "--label-height",
            labelHeight
        );
        document.documentElement.style.setProperty(
            "--labels-per-row",
            labelsPerRow
        );

        barcodeList.innerHTML = "";
        labelSheet.innerHTML = "";
        previewSheet.innerHTML = "";

        for (let i = 0; i < quantity; i++) {
            const randomPart = Math.floor(Math.random() * 10000000000)
                .toString()
                .padStart(10, "0");
            const barcodeValue = prefix + randomPart;

            createDisplayBarcode(barcodeValue, barcodeType, barcodeSize);
            createLabelBarcode(barcodeValue, barcodeType, barcodeSize);
        }

        barcodesContainer.classList.remove("d-none");
        printBtn.disabled = false;
        previewBtn.disabled = false;
    }

    function createDisplayBarcode(barcodeValue, barcodeType, size) {
        const barcodeCol = document.createElement("div");
        barcodeCol.className = "col-md-4 col-sm-6 col-6 mb-3";

        const barcodeItem = document.createElement("div");
        barcodeItem.className = "barcode-item";

        const barcodeCanvas = document.createElement("canvas");
        barcodeCanvas.className = "barcode-canvas";

        const barcodeText = document.createElement("div");
        barcodeText.className = "barcode-value";
        barcodeText.textContent = barcodeValue;

        barcodeItem.appendChild(barcodeCanvas);
        barcodeItem.appendChild(barcodeText);
        barcodeCol.appendChild(barcodeItem);
        barcodeList.appendChild(barcodeCol);

        try {
            JsBarcode(barcodeCanvas, barcodeValue, {
                format: barcodeType,
                width: size,
                height: 50,
                displayValue: true,
                fontSize: 12,
                lineColor: "#000000",
                background: "#ffffff",
                margin: 5,
            });
        } catch (e) {
            console.error("Error generating barcode:", e);
            barcodeText.textContent =
                "Error: " + barcodeValue + " - " + e.message;
            barcodeCanvas.style.display = "none";
        }
    }

    function createLabelBarcode(barcodeValue, barcodeType, size) {
        const labelWidth = document.getElementById("label_width").value || 50;
        const labelHeight = document.getElementById("label_height").value || 20;

        // For printing
        const labelItem = document.createElement("div");
        labelItem.className = "label-barcode-item";

        const barcodeCanvas = document.createElement("canvas");
        barcodeCanvas.className = "label-barcode-canvas";

        const barcodeText = document.createElement("div");
        barcodeText.className = "label-barcode-value";
        barcodeText.textContent = barcodeValue;

        labelItem.appendChild(barcodeCanvas);
        labelItem.appendChild(barcodeText);
        labelSheet.appendChild(labelItem.cloneNode(true));
        previewSheet.appendChild(labelItem);

        try {
            const barcodeHeight = Math.max(10, labelHeight * 0.6);

            JsBarcode(barcodeCanvas, barcodeValue, {
                format: barcodeType,
                width: size,
                height: barcodeHeight,
                displayValue: false,
                lineColor: "#000000",
                background: "transparent",
                margin: 1,
            });
        } catch (e) {
            console.error("Error generating label barcode:", e);
            barcodeText.textContent =
                "Error: " + barcodeValue + " - " + e.message;
            barcodeCanvas.style.display = "none";
        }
    }

    function printBarcodes() {
        printContainer.classList.remove("d-none");

        setTimeout(() => {
            const canvases = printContainer.querySelectorAll("canvas");
            let generatedCount = 0;

            canvases.forEach((canvas) => {
                const barcodeValue = canvas.nextElementSibling.textContent;
                const barcodeType =
                    document.getElementById("barcode_type").value;
                const barcodeSize =
                    parseInt(document.getElementById("barcode_size").value) ||
                    2;

                try {
                    JsBarcode(canvas, barcodeValue, {
                        format: barcodeType,
                        width: barcodeSize,
                        height: 15,
                        displayValue: false,
                        lineColor: "#000000",
                        background: "transparent",
                        margin: 1,
                    });
                    generatedCount++;
                } catch (e) {
                    console.error("Error generating barcode:", e);
                }
            });

            const checkGeneration = setInterval(() => {
                if (generatedCount === canvases.length) {
                    clearInterval(checkGeneration);

                    setTimeout(() => {
                        window.print();

                        setTimeout(() => {
                            printContainer.classList.add("d-none");
                        }, 500);
                    }, 100);
                }
            }, 50);
        }, 100);
    }

    function previewBarcodes() {
        previewModal.show();
    }

    function printFromPreview() {
        previewModal.hide();
        setTimeout(printBarcodes, 500);
    }
});
