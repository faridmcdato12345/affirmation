module.exports = {
  darkMode: "class",
  content: [
    "./resources/js/**/*.vue",
    "./resources/views/**/*.blade.php"
  ],
  theme: {
    screens: {
      "xs": "375px",
      // => @media (min-width: 375px) { ... }
      "sm": "640px",
      // => @media (min-width: 640px) { ... }

      "md": "768px",
      // => @media (min-width: 768px) { ... }

      "lg": "1024px",
      // => @media (min-width: 1024px) { ... }

      "xl": "1280px",
      // => @media (min-width: 1280px) { ... }

      "2xl": "1536px",
      // => @media (min-width: 1536px) { ... }
    },
    extend: {
      colors: {
        "theme-green": "#096A2E",
        "hover-theme-green": "#8ABE53"
      }
    },
  },
  safelist: [
    'border-2',
    'border-solid',
    'focus:ring',
    {
      pattern: /bg-(red|green|blue|orange|gray)-(100|200|300|400|500|600|700)/,
      variants: ['hover', 'focus', 'lg:hover', 'active', 'disabled:hover'],
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
