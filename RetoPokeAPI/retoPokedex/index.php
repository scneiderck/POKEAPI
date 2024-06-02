<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icono de la pestaña del navegador -->
    <link rel="shortcut icon" href="./assets/imgs/pikachu.png"/>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="./assets/styles.css">
    <!-- Título de la página -->
    <title>POKEDEX ESNEYDER</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Div para mostrar un indicador de carga -->
    <div class="loader"></div>

    <!-- Div para el fondo de la página -->
    <div class="background-div"></div>
    
    <!-- Contenedor principal -->
    <div style="z-index: 1;" class="container">
        <!-- Encabezado con el logo de Pokémon -->
        <div class="header text-center">
            <img src="./assets/imgs/pokemon_logo.png" alt="PokemonLogo" class="pokemon-logo img-fluid mx-auto d-block mt-4" style="width: 50%;">
        </div>

        <!-- Filtros de búsqueda -->
        <div class="filters mt-4 d-flex justify-content-center">
            <form class="row g-6" method="GET" action="index.php">
                <!-- Campo de búsqueda por nombre -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                </div>
                <!-- Selección de opciones de filtro -->
                <div class="col-md-4">
                    <select name="sort" class="form-select">
                        <option value="">Filtros</option>
                        <option value="name_asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : ''; ?>>Nombre (A-Z)</option>
                        <option value="name_desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : ''; ?>>Nombre (Z-A)</option>
                        <option value="number_asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'number_asc' ? 'selected' : ''; ?>>Número (Menor a Mayor)</option>
                        <option value="number_desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'number_desc' ? 'selected' : ''; ?>>Número (Mayor a Menor)</option>
                    </select>
                </div>
                <!-- Botón para aplicar los filtros -->
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Aplicar Filtro <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg></button>
                </div>
            </form>
        </div>

        <!-- Contenedor para mostrar los Pokémon -->
        <div id="pokemon-container" class="pokemons row mt-4">
            <?php include 'db.php'; ?>
        </div>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script para cargar más Pokémon -->
    <script>
        $(document).ready(function() {
            let offset = 20;
            const limit = 20;

            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadMorePokemon();
                }
            });

            function loadMorePokemon() {
                $('#loading').show();
                $.ajax({
                    url: 'load_more.php',
                    type: 'GET',
                    data: {
                        offset: offset,
                        sort: '<?php echo isset($_GET['sort']) ? $_GET['sort'] : ''; ?>',
                    },
                    success: function(data) {
                        $('#pokemon-container').append(data);
                        offset += limit;
                        $('#loading').hide();
                    },
                    error: function() {
                        $('#loading').hide();
                        alert('No se pudieron cargar más Pokémon.');
                    }
                });
            }

        });
    </script>

    <!-- Script para aplicar un efecto al hacer clic en el logo de Pokémon -->
    <script>
        const pokemonLogo = document.querySelector('.pokemon-logo');
        pokemonLogo.addEventListener('click', () => {
            pokemonLogo.classList.toggle('rotate');
        });
    </script>
</body>
</html>
