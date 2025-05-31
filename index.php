<?php
// Połączenie z bazą danych
$conn = new mysqli("127.0.0.1", "s228", "iNP2t1uppl9D", "dbs228"); // <- zmień dane logowania
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Ustal wybraną opcję z menu
$view = isset($_GET['view']) ? $_GET['view'] : '';
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>zad.mat</title>

    <link href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css" rel="stylesheet" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <a href="?view=jeep">Łaziki</a>
    <a href="?view=areas">Obszary</a>
    <a href="?view=measurement">Pomiary</a>
    <a href="?view=ex71">Zadanie 7.1</a>
    <a href="?view=ex72">Zadanie 7.2</a>
    <a href="?view=ex73">Zadanie 7.3</a>
    <a href="?view=ex74">Zadanie 7.4</a>
    <a href="?view=ex75">Zadanie 7.5</a>
    <a href="https://arkusze.pl/maturalne/informatyka-2025-maj-matura-rozszerzona.pdf" 
       class="menu-link external-link" 
       target="_blank" 
       rel="noopener noreferrer">
        📖 Matura - Maj 2025
    </a>
  </div>
  <div class="content">
    <?php

if (empty($view)) {
    echo "<h2>Poszukiwania wody na Marsie</h2>";
    echo "<p class='task-paragraph'>
        Witamy w centrum dowodzenia misji eksploracji Marsa!<br>
        Po lewej stronie wybierz jedną z sekcji, aby przejrzeć dane łazików, obszarów oraz wyniki pomiarów.<br><br>
        Celem projektu jest zbadanie występowania wody na powierzchni i pod powierzchnią Czerwonej Planety.
    </p>";
echo '<div style="background-color: black !important; opacity: 0.8; max-width: 950px; margin: 10px;>
         <div class="loading" id="loading">
            <h1>Initializing Mars Explorer</h1>
            <div class="loading-bar">
                <div class="loading-progress" id="loadingProgress"></div>
            </div>
         </div>

            <div class="container">
            <div class="header">
                <h1>MARS 3D EKSPLORER</h1>
                <p class="subtitle">Poznaj planetę mars.</p>
            </div>
            
            <canvas id="marsCanvas"></canvas>
            
            <div class="controls">
                <p>przeciągnij myszką, aby obrócić, przybliż se scrollem</p>
            </div>
            
            
            <div class="mars-fact" id="marsFact">
                Olympus Mons: The tallest volcano in our solar system at 21.9 km
            </div>
            
            <div class="toggle-info" id="toggleInfo">i</div>
            <div class="info-panel hidden" id="infoPanel">
                <h3>Mars Facts</h3>
                <p>• Diameter: 6,779 km (about half of Earth)</p>
                <p>• Gravity: 3.7 m/s² (38% of Earth\'s)</p>
                <p>• Day Length: 24.6 hours</p>
                <p>• Year Length: 687 Earth days</p>
                <p>• Temperature: -153°C to 20°C</p>
                <p>• Atmosphere: 95% CO₂, 3% N₂, 1.6% Ar</p>
                <p>• Moons: Phobos & Deimos</p>
            </div>
        </div>
       </div>';
}



elseif ($view == 'jeep') {
    echo "<h2>Łaziki</h2>";
    $res = $conn->query("SELECT * FROM laziki");
    if ($res && $res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Rok wysłania</th>
                        <th>Współrzędne lądowania</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nazwa']}</td>
                    <td>{$row['rok_wyslania']}</td>
                    <td>{$row['wsp_ladowania']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Brak danych w tabeli łaziki.</p>";
    }
}


elseif ($view == 'areas') {
    echo "<h2>Obszary</h2>";
    $res = $conn->query("SELECT * FROM obszary");
    if ($res && $res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>Kod ID</th>
                        <th>Nazwa obszaru</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['kod_id']}</td>
                    <td>{$row['nazwa_o']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Brak danych w tabeli obszary.</p>";
    }
}

elseif ($view == 'measurement') {
    echo "<h2>Pomiary</h2>";
    $res = $conn->query("SELECT * FROM pomiary");
    if ($res && $res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>Nr łazika</th>
                        <th>Data</th>
                        <th>Kod obszaru</th>
                        <th>Współrzędne</th>
                        <th>Głębokość</th>
                        <th>Ilość (m³)</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nr_id']}</td>
                    <td>{$row['data']}</td>
                    <td>{$row['kod_id']}</td>
                    <td>{$row['wspolrzedne']}</td>
                    <td>{$row['glebokosc']}</td>
                    <td>{$row['ilosc']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Brak danych w tabeli pomiary.</p>";
    }
}

elseif ($view == 'ex71') {
    echo "<h2>Zadanie 7.1</h2>";
    echo "<p class='task-paragraph'>
        <strong>TREŚĆ</strong> : Podaj nazwę łazika, który wykonał najwięcej pomiarów oraz liczbę tych pomiarów.
    </p>";

    $res = $conn->query("
        SELECT l.nazwa, COUNT(*) AS liczba_pomiarow
        FROM laziki l
        JOIN pomiary p ON l.nr_id = p.nr_id
        GROUP BY l.nazwa
        ORDER BY liczba_pomiarow DESC
        LIMIT 1
    ");

    if ($res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                <tr>
                    <th>Nazwa łazika</th>
                    <th>Liczba pomiarów</th>
                </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nazwa']}</td>
                    <td>{$row['liczba_pomiarow']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p style='color:white;'>Brak wyników.</p>";
    }

    echo "<div>
            Zapytanie SQL:<br>
            

        <pre><code class='language-sql'>
SELECT l.nazwa, COUNT(*) AS liczba_pomiarow
FROM laziki l
JOIN pomiary p ON l.nr_id = p.nr_id
GROUP BY l.nazwa<br>
ORDER BY liczba_pomiarow DESC
LIMIT 1
        </code></pre>

          </div>";
}
elseif ($view == 'ex72') {
    echo "<h2>Zadanie 7.2</h2>";
    echo "<p class='task-paragraph'>
        <strong>TREŚĆ</strong> : Podaj nazwy łazików oraz liczbę wykonanych przez nie pomiarów.
    </p>";

    $res = $conn->query("
        SELECT l.nazwa, COUNT(*) AS liczba_pomiarow
        FROM laziki l
        JOIN pomiary p ON l.nr_id = p.nr_id
        GROUP BY l.nazwa
        ORDER BY l.nazwa
    ");

    if ($res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                <tr>
                    <th>Nazwa łazika</th>
                    <th>Liczba pomiarów</th>
                </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nazwa']}</td>
                    <td>{$row['liczba_pomiarow']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p style='color:white;'>Brak wyników.</p>";
    }

    echo "<div>
            Zapytanie SQL:<br>
            <pre><code class='language-sql'>
SELECT l.nazwa, COUNT(*) AS liczba_pomiarow<br>
FROM laziki l<br>
JOIN pomiary p ON l.nr_id = p.nr_id<br>
GROUP BY l.nazwa<br>
ORDER BY l.nazwa
            </pre></code>
          </div>";
}
elseif ($view == 'ex73') {
    echo "<h2>Zadanie 7.3</h2>";
    echo "<p class='task-paragraph'>
        <strong>TREŚĆ</strong> : Podaj kod obszaru, w którym wykonano największą liczbę pomiarów.
    </p>";

    $res = $conn->query("
        SELECT kod_id, COUNT(*) AS liczba_pomiarow
        FROM pomiary
        GROUP BY kod_id
        ORDER BY liczba_pomiarow DESC
        LIMIT 1
    ");

    if ($res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                <tr>
                    <th>Kod obszaru</th>
                    <th>Liczba pomiarów</th>
                </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['kod_id']}</td>
                    <td>{$row['liczba_pomiarow']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p style='color:white;'>Brak wyników.</p>";
    }

    echo "<div>
            Zapytanie SQL:<br>
            <pre><code class='language-sql'>
SELECT kod_id, COUNT(*) AS liczba_pomiarow<br>
FROM pomiary<br>
GROUP BY kod_id<br>
ORDER BY liczba_pomiarow DESC<br>
LIMIT 1
            </pre></code>
          </div>";
}
elseif ($view == 'ex74') {
    echo "<h2>Zadanie 7.4</h2>";
    echo "<p class='task-paragraph'>
        <strong>TREŚĆ</strong> : Podaj nazwy łazików, które wylądowały na półkuli południowej, ale wykonywały pomiary na obu półkulach: północnej (N) i południowej (S).
    </p>";

    $res = $conn->query("
        SELECT DISTINCT l.nazwa
FROM laziki l
JOIN pomiary p ON l.nr_id = p.nr_id
WHERE l.wsp_ladowania LIKE '%S%' 
AND EXISTS (
    SELECT 1 FROM pomiary p1
    WHERE p1.nr_id = l.nr_id AND p1.wspolrzedne LIKE '%N%'
)
AND EXISTS (
    SELECT 1 FROM pomiary p2
    WHERE p2.nr_id = l.nr_id AND p2.wspolrzedne LIKE '%S%'
)

    ");

    if ($res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                <tr>
                    <th>Nazwa łazika</th>
                </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nazwa']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p style='color:white;'>Brak wyników.</p>";
    }

    echo "<div>
            Zapytanie SQL:<br>
        <pre><code class='language-sql'>
SELECT DISTINCT l.nazwa
FROM laziki l
JOIN pomiary p ON l.nr_id = p.nr_id
WHERE l.wsp_ladowania LIKE '%S%' 
AND EXISTS (
    SELECT 1 FROM pomiary p1
    WHERE p1.nr_id = l.nr_id AND p1.wspolrzedne LIKE '%N%'
)
AND EXISTS (
    SELECT 1 FROM pomiary p2
    WHERE p2.nr_id = l.nr_id AND p2.wspolrzedne LIKE '%S%'
)

        </pre></code>
          </div>";
}
elseif ($view == 'ex75') {
    echo "<h2>Zadanie 7.5</h2>";
    echo "<p class='task-paragraph'>
        <strong>Treść:</strong><br>
        Do tabel utworzonych na podstawie opisanych wcześniej plików dołączamy kolejną – o nazwie <strong>Producent</strong>, w której zapisano informacje o producentach poszczególnych modeli łazików.<br><br>
        Tabela <code>Producent</code> zawiera następujące pola:<br>
        <code>kod_producenta</code> – unikatowy kod producenta<br>
        <code>nazwa</code> – nazwa producenta<br>
        <code>kraj</code> – kraj producenta<br><br>
        Do tabeli <code>laziki</code> dodano pole <code>kod_producenta</code>.<br><br>
        Napisz w języku SQL zapytanie, w wyniku którego otrzymasz listę nazw producentów, których łaziki badały obszar Marsa o nazwie <strong>Arcadia</strong> w roku <strong>2060</strong>.<br>
        Nazwy producentów nie mogą się powtarzać.
    </p>";

    // PRZYKŁADOWE DANE – możesz je wprowadzić do swojej bazy
    echo "<h3>Przykładowe dane w tabeli Producent</h3>";
    $res = $conn->query("SELECT * FROM producent");
    if ($res && $res->num_rows > 0) {
        echo "<div class='table-wrapper'>";
        echo "<table class='styled-table'>
                <thead>
                    <tr>
                        <th>kod_producenta</th>
                        <th>nazwa</th>
                        <th>kraj</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['kod_producenta']}</td>
                    <td>{$row['nazwa']}</td>
                    <td>{$row['kraj']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Brak danych w tabeli obszary.</p>";
    }

    // WŁAŚCIWE ZAPYTANIE
    $res = $conn->query("
SELECT DISTINCT pr.nazwa
FROM producent pr
JOIN laziki l ON pr.kod_producenta = l.kod_producenta
JOIN pomiary p ON l.nr_id = p.nr_id
JOIN obszary o ON p.kod_id = o.kod_id
WHERE o.nazwa_o = 'Arcadia'
AND YEAR(p.data) = 2060
    ");

    if ($res->num_rows > 0) {
        echo "<h3>Wynik zapytania</h3>";
        echo "<div class='table-wrapper'>
                <table class='styled-table'>
                    <thead><tr><th>Nazwa producenta</th></tr></thead>
                    <tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr><td>{$row['nazwa']}</td></tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p style='color:white;'>Brak wyników.</p>";
    }

    echo "<div style='margin-top:20px;'>
            <h3>Użyte zapytanie SQL:</h3>
            <pre><code class='language-sql'>
SELECT DISTINCT pr.nazwa
FROM producent pr
JOIN laziki l ON pr.kod_producenta = l.kod_producenta
JOIN pomiary p ON l.nr_id = p.nr_id
JOIN obszary o ON p.kod_id = o.kod_id
WHERE o.nazwa_o = 'Arcadia'
AND YEAR(p.data) = 2060;
            </code></pre>
          </div>";
}



// dodaj kolejne warunki dla zadań 7.1, 7.2 itd.\

    

    
    


?>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/prism.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs/components/prism-sql.min.js"></script>

    <script>
        // Array of interesting Mars facts
        const marsFacts = [
            "Olympus Mons: The tallest volcano in our solar system at 21.9 km",
            "Valles Marineris: A canyon system stretching over 4,000 km long",
            "Mars has the largest dust storms in the solar system",
            "Mars appears red due to iron oxide (rust) in its soil",
            "Mars has two moons: Phobos and Deimos",
            "Mars has seasons like Earth, but they last twice as long",
            "The atmospheric pressure on Mars is less than 1% of Earth's",
            "Mars has the largest volcano in the solar system",
            "Water exists on Mars as ice at the poles and below the surface"
        ];
        
        // Create the 3D Mars scene
        function initMarsScene() {
            // Scene setup
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 8;
            
            const renderer = new THREE.WebGLRenderer({
                canvas: document.getElementById('marsCanvas'),
                antialias: true,
                alpha: true
            });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            
            // Create Mars with detailed surface
            const marsGeometry = new THREE.SphereGeometry(2.5, 128, 128);
            
            // Load high-resolution textures
            const textureLoader = new THREE.TextureLoader();
            
            // Use higher resolution textures for better surface detail
            const marsTexture = textureLoader.load('https://raw.githubusercontent.com/mrdoob/three.js/master/examples/textures/planets/mars_4k_color.jpg');
            const marsBump = textureLoader.load('https://raw.githubusercontent.com/mrdoob/three.js/master/examples/textures/planets/mars_4k_normal.jpg');
            const marsSpecular = textureLoader.load('https://raw.githubusercontent.com/mrdoob/three.js/master/examples/textures/planets/mars_4k_specular.jpg');
            
            const marsMaterial = new THREE.MeshPhongMaterial({
                map: marsTexture,
                bumpMap: marsBump,
                bumpScale: 0.08,
                specularMap: marsSpecular,
                specular: new THREE.Color(0x333333),
                shininess: 15,
                reflectivity: 0.2
            });
            
            const mars = new THREE.Mesh(marsGeometry, marsMaterial);
            scene.add(mars);
            
            // Add atmospheric glow with particles
            const atmosphereGeometry = new THREE.SphereGeometry(2.55, 64, 64);
            const atmosphereMaterial = new THREE.MeshBasicMaterial({
                color: 0xff5500,
                transparent: true,
                opacity: 0.07,
                wireframe: true
            });
            const atmosphere = new THREE.Mesh(atmosphereGeometry, atmosphereMaterial);
            scene.add(atmosphere);
            
            // Create particle system for stars
            const starCount = 5000;
            const starGeometry = new THREE.BufferGeometry();
            const starPositions = new Float32Array(starCount * 3);
            
            for (let i = 0; i < starCount * 3; i += 3) {
                const radius = 100 + Math.random() * 900;
                const theta = Math.random() * Math.PI * 2;
                const phi = Math.acos(2 * Math.random() - 1);
                
                starPositions[i] = radius * Math.sin(phi) * Math.cos(theta);
                starPositions[i + 1] = radius * Math.sin(phi) * Math.sin(theta);
                starPositions[i + 2] = radius * Math.cos(phi);
            }
            
            starGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
            
            const starMaterial = new THREE.PointsMaterial({
                color: 0xffffff,
                size: 0.5,
                sizeAttenuation: true,
                transparent: true,
                opacity: 0.8
            });
            
            const stars = new THREE.Points(starGeometry, starMaterial);
            scene.add(stars);
            
            // Add lighting
            const ambientLight = new THREE.AmbientLight(0x333333);
            scene.add(ambientLight);
            
            const sunLight = new THREE.DirectionalLight(0xffffff, 1.5);
            sunLight.position.set(15, 5, 10);
            scene.add(sunLight);
            
            const backLight = new THREE.DirectionalLight(0xff6600, 0.4);
            backLight.position.set(-10, -3, -5);
            scene.add(backLight);
            
            // Add orbit controls
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.rotateSpeed = 0.7;
            controls.autoRotate = true;
            controls.autoRotateSpeed = 0.3;
            controls.minDistance = 4;
            controls.maxDistance = 15;
            
            // Handle window resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
            
            // Update Mars fact periodically
            let factIndex = 0;
            const factElement = document.getElementById('marsFact');
            
            function updateMarsFact() {
                factElement.textContent = marsFacts[factIndex];
                factIndex = (factIndex + 1) % marsFacts.length;
                
                // Animate fact appearance
                factElement.style.transform = 'translateY(20px)';
                factElement.style.opacity = '0';
                
                setTimeout(() => {
                    factElement.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                    factElement.style.transform = 'translateY(0)';
                    factElement.style.opacity = '0.9';
                }, 50);
            }
            
            // Initial fact update
            updateMarsFact();
            setInterval(updateMarsFact, 7000);
            
            // Animate the scene
            function animate() {
                requestAnimationFrame(animate);
                
                // Slow rotation of Mars
                mars.rotation.y += 0.001;
                
                // Pulsing atmosphere effect
                atmosphere.scale.setScalar(1 + Math.sin(Date.now() * 0.001) * 0.005);
                
                // Update controls
                controls.update();
                
                renderer.render(scene, camera);
            }
            
            // Start animation
            animate();
            
            // Simulate loading progress
            let progress = 0;
            const loadingInterval = setInterval(() => {
                progress += Math.random() * 10;
                document.getElementById('loadingProgress').style.width = `${progress}%`;
                
                if (progress >= 100) {
                    clearInterval(loadingInterval);
                    setTimeout(() => {
                        document.getElementById('loading').style.opacity = 0;
                        setTimeout(() => {
                            document.getElementById('loading').style.display = 'none';
                        }, 1000);
                    }, 500);
                }
            }, 200);
        }
        
        // Initialize scene
        initMarsScene();
        
        // Info panel toggle
        document.getElementById('toggleInfo').addEventListener('click', () => {
            document.getElementById('infoPanel').classList.toggle('hidden');
        });
    </script>
    <script>
// Loading animation
document.addEventListener('DOMContentLoaded', function() {
    let progress = 0;
    const loadingInterval = setInterval(() => {
        progress += Math.random() * 15;
        if(progress > 100) progress = 100;
        document.getElementById('loadingProgress').style.width = `${progress}%`;
        
        if(progress >= 100) {
            clearInterval(loadingInterval);
            setTimeout(() => {
                document.getElementById('loading').style.display = 'none';
            }, 500);
        }
    }, 200);
});

// Info panel toggle
document.getElementById('toggleInfo').addEventListener('click', function() {
    const panel = document.getElementById('infoPanel');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
});

// Random Mars facts
const marsFacts = [
    'Valles Marineris: A canyon system stretching over 4,000 km - 10 times longer than Earth\'s Grand Canyon',
    'Tharsis Volcanoes: Contains 12 giant volcanoes in a 4,000 km wide region',
    'Polar Ice Caps: Made of water and frozen carbon dioxide (dry ice)',
    'Surface Color: Red due to iron oxide (rust) in the soil',
    'Atmospheric Pressure: Less than 1% of Earth\'s at sea level'
];

document.getElementById('marsFact').textContent = 
    marsFacts[Math.floor(Math.random() * marsFacts.length)];
</script>
<!-- Animacja marsa zrobiona przez AI -->

</body> 
</html>
