import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["toggle"]

    connect() {
        console.log("Theme controller connected")
        this.initializeTheme()
        this.updateToggleState()

        // Listen for system theme changes
        this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
        this.mediaQuery.addEventListener('change', this.handleSystemThemeChange.bind(this))
    }

    disconnect() {
        if (this.mediaQuery) {
            this.mediaQuery.removeEventListener('change', this.handleSystemThemeChange.bind(this))
        }
    }

    // Initialize theme on page load
    initializeTheme() {
        const savedTheme = localStorage.getItem('theme')
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches

        let theme = savedTheme || 'system'

        this.applyTheme(theme)
        this.broadcastThemeChange(theme)
    }

    // Toggle between light, dark, and system
    toggle() {
        const currentTheme = localStorage.getItem('theme') || 'system'
        let newTheme

        switch(currentTheme) {
            case 'light':
                newTheme = 'dark'
                break
            case 'dark':
                newTheme = 'system'
                break
            case 'system':
            default:
                newTheme = 'light'
                break
        }

        this.setTheme(newTheme)
    }

    // Set specific theme
    setTheme(theme) {
        localStorage.setItem('theme', theme)
        this.applyTheme(theme)
        this.updateToggleState()
        this.broadcastThemeChange(theme)
    }

    // Apply theme to document
    applyTheme(theme) {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        const isDark = theme === 'system' ? prefersDark : theme === 'dark'

        document.documentElement.classList.toggle('dark', isDark)

        // Also apply to body for immediate visual feedback
        document.body.classList.toggle('dark', isDark)

        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor(isDark)

        console.log(`Theme applied: ${theme} (isDark: ${isDark})`)
    }

    // Update meta theme-color for mobile browsers
    updateMetaThemeColor(isDark) {
        let themeColorMeta = document.querySelector('meta[name="theme-color"]')
        if (!themeColorMeta) {
            themeColorMeta = document.createElement('meta')
            themeColorMeta.name = 'theme-color'
            document.head.appendChild(themeColorMeta)
        }

        themeColorMeta.content = isDark ? '#18181b' : '#fafafa'
    }

    // Update toggle button state
    updateToggleState() {
        const theme = localStorage.getItem('theme') || 'system'

        this.toggleTargets.forEach(toggle => {
            // Update button text/icon based on current theme
            const icon = toggle.querySelector('svg')
            const text = toggle.querySelector('.theme-text')

            if (icon) {
                this.updateToggleIcon(icon, theme)
            }

            if (text) {
                text.textContent = this.getThemeDisplayName(theme)
            }

            // Update aria-label for accessibility
            toggle.setAttribute('aria-label', `Switch to ${this.getNextTheme(theme)} mode`)
        })
    }

    // Update toggle icon based on theme
    updateToggleIcon(icon, theme) {
        const sunIcon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>`
        const moonIcon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>`
        const systemIcon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>`

        let iconPath
        switch(theme) {
            case 'light':
                iconPath = sunIcon
                break
            case 'dark':
                iconPath = moonIcon
                break
            case 'system':
            default:
                iconPath = systemIcon
                break
        }

        icon.innerHTML = iconPath
    }

    // Get display name for theme
    getThemeDisplayName(theme) {
        switch(theme) {
            case 'light': return 'Light'
            case 'dark': return 'Dark'
            case 'system': return 'System'
            default: return 'System'
        }
    }

    // Get next theme in cycle
    getNextTheme(currentTheme) {
        switch(currentTheme) {
            case 'light': return 'dark'
            case 'dark': return 'system'
            case 'system': return 'light'
            default: return 'light'
        }
    }

    // Handle system theme changes
    handleSystemThemeChange(e) {
        const savedTheme = localStorage.getItem('theme')
        if (savedTheme === 'system' || !savedTheme) {
            this.applyTheme('system')
            this.broadcastThemeChange('system')
        }
    }

    // Broadcast theme change to other components
    broadcastThemeChange(theme) {
        const event = new CustomEvent('theme:changed', {
            detail: {
                theme,
                isDark: this.isDarkMode()
            }
        })
        document.dispatchEvent(event)
    }

    // Check if currently in dark mode
    isDarkMode() {
        return document.documentElement.classList.contains('dark')
    }

    // Public method to get current theme
    getCurrentTheme() {
        return localStorage.getItem('theme') || 'system'
    }
}