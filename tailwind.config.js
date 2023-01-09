/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
        keyframes: {
            bounceslow: {
                '0%, 100%': { transform: 'translateY(-6%)', 'animation-timing-function': 'cubic-bezier(0.8,0,1,1)' },
                '50%': { transform: 'none', 'animation-timing-function': 'cubic-bezier(0,0,0.2,1)' }
            },
            bounceIn: {
                '0%, 100%': { transform: 'translateX(-20%)' },
                '50%': { transform: 'translateX(10%)' },
                'to': { transform: 'none' },
            }
        },
        animation: {
            'bounce-slow': 'bounceslow 1s ease-in-out infinite',
            'bounce-in': 'bounceIn 1s ease-in-out both',
        }
    },
  },
  plugins: [],
}
