import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js", // <--- ini wajib
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#FF3C5F",
                secondary: "#2b2c2fff",
                dark: "#161616ff",
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        ol: {
                            listStyleType: "decimal",
                            paddingLeft: theme("spacing.6"), // supaya angka tetap muncul di kiri
                        },
                        "ol > li:marker": {
                            position: "relative",
                            backgroundColor: theme("colors.primary"),
                            color: theme("colors.white"),
                            padding: `${theme("spacing.1")} ${theme(
                                "spacing.2"
                            )}`,
                            borderRadius: theme("borderRadius.lg"),
                            marginBottom: theme("spacing.2"),
                        },
                       
                    },
                },
                invert: {
                    css: {
                        "ol > li": {
                            backgroundColor: theme("colors.primary.600"),
                            color: theme("colors.white"),
                        },
                        "ol > li::marker": {
                            color: theme("colors.gray.200"),
                        },
                    },
                },
            }),
        },
    },

    plugins: [
        forms,
        require("flowbite/plugin"),
        require("@tailwindcss/typography"),
    ],
};
