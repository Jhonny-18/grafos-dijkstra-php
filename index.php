<?php
function dijkstra($graph, $start)
{
  $distances = [];
  $visited = [];
  $previous = [];
  foreach ($graph as $node => $edges) {
    $distances[$node] = INF;
    $previous[$node] = null;
    $visited[$node] = false;
  }
  $distances[$start] = 0;
  while (true) {
    $minDistance = INF;
    $minNode = null;
    foreach ($distances as $node => $distance) {
      if (!$visited[$node] && $distance < $minDistance) {
        $minDistance = $distance;
        $minNode = $node;
      }
    }
    if ($minNode === null) {
      break;
    }

    $visited[$minNode] = true;
    foreach ($graph[$minNode] as $neighbor => $cost) {
      $newDistance = $distances[$minNode] + $cost;
      if ($newDistance < $distances[$neighbor]) {
        $distances[$neighbor] = $newDistance;
        $previous[$neighbor] = $minNode;
      }
    }
  }
  return [$distances, $previous];
}

// a = BRASIL b = EUA c = CANADÁ d = ALEMANHA e = JAPÃO

$graph = [
  'brasil' => ['eua' => 800, 'alemanha' => 1200],
  'eua' => ['brasil' => 800, 'canada' => 400, 'japao' => 2000],
  'canada' => ['eua' => 400, 'japao' => 1800],
  'alemanha' => ['brasil' => 1200, 'japao' => 1100],
  'japao' => ['eua' => 2000, 'alemanha' => 1100, 'canada' => 1800],
];

$start = $_GET['homeLocal'];
$destination = $_GET['destination'];

function getPath($previous, $destination) {
  $path = [];
  $current = $destination;
  while ($current !== null) {
    array_unshift($path, $current); 
    $current = $previous[$current];
  }
  return $path;
}

list($distances, $previous) = dijkstra($graph, $start);

if (isset($distances[$destination])) {
  echo "Distância de $start para $destination = " . $distances[$destination] . " km\n";
  $path = getPath($previous, $destination);
  echo "Caminho percorrido: " . implode(" -> ", $path) . "\n";
} else {
  echo "Destino inválido.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grafos - Dijkstra</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Calculadora de Distâncias</h1>
  <form method="GET">
    <label for="homeLocal">Seu Local de Partida:</label>
    <select name="homeLocal" id="homeLocal">
      <option value="brasil">Brasil</option>
      <option value="eua">EUA</option>
      <option value="canada">Canadá</option>
      <option value="alemanha">Alemanha</option>
      <option value="japao">Japão</option>
    </select>

    <label for="destination">Seu Local de Destino:</label>
    <select name="destination" id="destination">
      <option value="brasil">Brasil</option>
      <option value="eua">EUA</option>
      <option value="canada">Canadá</option>
      <option value="alemanha">Alemanha</option>
      <option value="japao">Japão</option>
    </select>
    <button type="submit" id="btn-enviar">Calcular</button>
  </form>

  <script src="script.js"></script>
</body>

</html>


