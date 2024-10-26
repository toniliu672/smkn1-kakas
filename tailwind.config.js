/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{html,js,php}",         // File di root
    "./auth/**/*.{html,js,php}",  // File di folder auth
    "./components/**/*.{html,js,php}", // File di folder components
    "./admin/**/*.{html,js,php}", // File di folder admin
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

