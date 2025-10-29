import os

def generate_html_table(image_folder="pics", output_file="index.html"):
    # Hämta alla bildfiler i mappen
    image_files = [f for f in os.listdir(image_folder)
                   if f.lower().endswith(('.png', '.jpg', '.jpeg', '.gif', '.bmp'))]

    # Sortera bilderna
    image_files.sort()

    # Skapa HTML-kod
    html = """<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Röstningspoll</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        button { border: none; background: none; cursor: pointer; }
        img { max-width: 150px; max-height: 150px; }
    </style>
</head>
<body>
    <h1>Röstningspoll</h1>
    <table>
"""

    # Lägg till bilder i tabellen, 3 per rad, med knappar
    for i in range(0, len(image_files), 3):
        row_images = image_files[i:i+3]
        html += "        <tr>\n"
        for img in row_images:
            html += f'''            <td>
                <button data-img="{img}">
                    <img src="{image_folder}/{img}" alt="{img}">
                </button>
            </td>\n'''
        html += "        </tr>\n"

    # Avsluta tabellen och lägg till JavaScript
    html += """    </table>

<script>
const buttons = document.querySelectorAll("button[data-img]");

buttons.forEach(button => {
    button.addEventListener("click", () => {
        const imgName = button.getAttribute("data-img");
        alert("Du klickade på " + imgName);
    });
});
</script>

</body>
</html>
"""

    # Spara HTML-filen
    with open(output_file, "w", encoding="utf-8") as f:
        f.write(html)

    print(f"HTML-fil genererad: {output_file}")

# Kör skriptet
generate_html_table("pics")

