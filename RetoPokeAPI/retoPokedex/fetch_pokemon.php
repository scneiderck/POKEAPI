<?php
// Incluye el archivo de configuración para obtener acceso a la base de datos
include 'config/config.php';

// Función para obtener todos los Pokémon de la API
function getAllPokemon() {
    $pokemonList = [];
    // URL de la API para obtener todos los Pokémon
    $url = "https://pokeapi.co/api/v2/pokemon?limit=10000"; 
    // Obtiene los datos de la URL y los decodifica como JSON
    $data = file_get_contents($url);
    $allPokemonData = json_decode($data, true);
    // Verifica si existen resultados de Pokémon
    if (isset($allPokemonData['results'])) {
        // Obtiene la lista de Pokémon
        $pokemonList = $allPokemonData['results'];
    }
    return $pokemonList;
}

// Función para obtener los datos de un Pokémon específico
function getPokemonData($url) {
    // Obtiene los datos del Pokémon desde la URL y los decodifica como JSON
    $data = file_get_contents($url);
    return json_decode($data, true);
}

// Obtiene la lista de todos los Pokémon
$pokemonList = getAllPokemon();

// Recorre cada Pokémon en la lista
foreach ($pokemonList as $pokemon) {
    // Obtiene los datos del Pokémon
    $pokemonData = getPokemonData($pokemon['url']);

    // Extrae los atributos relevantes del Pokémon
    $id = sprintf("#%03d", $pokemonData['id']);
    $name = ucfirst($pokemonData['name']);
    $height = $pokemonData['height'];
    $weight = $pokemonData['weight'];
    $image_url = $pokemonData['sprites']['other']['official-artwork']['front_default'];

    // Obtiene los tipos del Pokémon
    $types = array_map(function($type_info) {
        return $type_info['type']['name'];
    }, $pokemonData['types']);
    // Convierte los tipos en una cadena separada por comas
    $types_str = implode(',', $types);

    // Obtiene las estadísticas base del Pokémon
    $base_stats = [];
    foreach ($pokemonData['stats'] as $stat) {
        $base_stats[$stat['stat']['name']] = $stat['base_stat'];
    }
    
    // Extrae las estadísticas base individuales del Pokémon
    $base_stat_hp = $base_stats['hp'];
    $base_stat_attack = $base_stats['attack'];
    $base_stat_defense = $base_stats['defense'];
    $base_stat_special_attack = $base_stats['special-attack'];
    $base_stat_special_defense = $base_stats['special-defense'];
    $base_stat_speed = $base_stats['speed'];

    // Crea una consulta SQL para insertar los datos del Pokémon en la base de datos
    $sql = "INSERT IGNORE INTO pokemon (id, name, height, weight, image_url, types, base_stat_hp, base_stat_attack, base_stat_defense, base_stat_special_attack, base_stat_special_defense, base_stat_speed) 
            VALUES ('$id','$name', $height, $weight, '$image_url', '$types_str', $base_stat_hp, $base_stat_attack, $base_stat_defense, $base_stat_special_attack, $base_stat_special_defense, $base_stat_speed)";

    // Ejecuta la consulta SQL
    if ($conn->query($sql) === TRUE) {
        // No hace nada si la consulta fue exitosa
    } else {
        // Imprime un mensaje de error si hay un error en la consulta
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cierra la conexión a la base de datos
$conn->close();

// Redirecciona a la página principal después de completar la inserción de datos
header('Location: index.php'); 
?>
