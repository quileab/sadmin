module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  purge: [
      './vendor/laravel/jetstream/**/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
