/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "laracasts": "rgb(50,138,241)" // Created "Class=xx" variable for design parts of the website
      }
    },
  },
  plugins: [],
}

