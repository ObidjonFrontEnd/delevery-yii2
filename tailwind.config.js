/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
    "./frontend/views/**/*.php",
    "./frontend/widgets/**/*.php",
    "./backend/views/**/*.php",
    "./backend/widgets/**/*.php",
    "./common/widgets/**/*.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}