<?php
// index.php

// Mapp där bilderna ligger
$imageFolder = __DIR__ . '/pics';

// Hämta alla bildfiler i mappen
$images = array_filter(scandir($imageFolder), function($file) use ($imageFolder) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg','jpeg','png','gif','bmp']) && is_file($imageFolder . '/' . $file);
});

// Sortera bilder alfabetiskt
sort($images);

?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Röstningspoll</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        button { border: none; background: none; cursor: pointer; }
        img { max-width: 150px; max-height: 150px; }
        #message { margin: 12px 0; font-weight: bold; }
        #message.ok { color: green; }
        #message.err { color: red; }
    </style>
</head>
<body>
    <h1>Röstningspoll</h1>

    <div id="message"></div>

    <table>
        <?php
        // Skriv ut bilder 3 per rad
        $perRow = 3;
        for ($i = 0; $i < count($images); $i++) {
            if ($i % $perRow === 0) echo "<tr>";
            $img = htmlspecialchars($images[$i]);
            echo <<<HTML
            <td>
                <button data-img="$img">
                    <img src="pics/$img" alt="$img" />
                </button>
            </td>
            HTML;
            if ($i % $perRow === $perRow - 1) echo "</tr>";
        }
        // Om sista raden inte fylldes, stäng raden
        if (count($images) % $perRow !== 0) echo "</tr>";
        ?>
    </table>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll("button[data-img]");
    const msg = document.getElementById('message');

    async function sendVote(imgName, btn) {
        try {
            btn.disabled = true;
            msg.textContent = "Rösten skickas...";
            msg.className = "";

            const body = new URLSearchParams();
            body.append('image', imgName);

            const res = await fetch('vote.php', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: body.toString()
            });

            const data = await res.json();

            if (res.ok && data.status === 'ok') {
                msg.textContent = data.message;
                msg.className = "ok";
            } else {
                msg.textContent = data.message || "Fel vid röstning";
                msg.className = "err";
            }
        } catch (e) {
            msg.textContent = "Nätverksfel eller serverfel.";
            msg.className = "err";
        } finally {
            setTimeout(() => { btn.disabled = false; }, 500);
        }
    }

    buttons.forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const imgName = button.getAttribute('data-img');
            sendVote(imgName, button);
        });
    });
});
</script>

</body>
</html>

