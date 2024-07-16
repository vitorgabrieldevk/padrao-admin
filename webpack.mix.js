const mix = require('laravel-mix');

mix.options({
    processCssUrls: false,
});

mix.disableNotifications(); // Desabilita as configurações do Laravel Mix

mix.setPublicPath('build'); // Define o diretório público para os arquivos compilados

mix.sass('assets/sass/app.scss', 'build/css'); // Compilação do Sass

mix.js('assets/js/app.js', 'build/js'); // Compilação do JavaScript

mix.copyDirectory('assets/images', 'build/images'); // Copia todas as imagens para o build final

mix.copyDirectory('assets/fonts', 'build/fonts'); // Copia todas as fonts para o build final

if (mix.inProduction()) {
    mix.version(); // Adiciona hashes aos arquivos para cache
}
