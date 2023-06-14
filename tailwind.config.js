/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/js/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  safelist: [
    'border-2',
    'border-solid', 
    'focus:ring',
    {
      pattern: /bg-(red|green|blue|orange)-(100|200|300|400|500|600|700)/,
      variants: ['hover', 'focus', 'lg:hover', 'active'],
    },
    {
      pattern: /ring-(red|green|blue|orange)-(100|200|300|400|500|600|700)/,
      variants: ['hover', 'focus', 'lg:hover', 'active'],
    },
    {
      pattern: /border-(red|green|blue|orange)-(100|200|300|400|500|600|700)/,
      variants: ['hover', 'focus', 'lg:hover', 'active'],
    },
  ],
  plugins: [],
}

