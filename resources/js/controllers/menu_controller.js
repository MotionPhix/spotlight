import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu", "overlay"]

    connect() {
        console.log("Menu controller connected")
    }

    toggle() {
        const menu = this.menuTarget
        const overlay = this.overlayTarget

        const isHidden = menu.classList.contains("hidden")

        if (isHidden) {
            this.show()
        } else {
            this.hide()
        }
    }

    show() {
        const menu = this.menuTarget
        const overlay = this.overlayTarget

        // Show menu
        menu.classList.remove("hidden")
        menu.classList.remove("-translate-x-full")
        menu.classList.add("translate-x-0")

        // Show overlay
        overlay.classList.remove("hidden")
    }

    hide() {
        const menu = this.menuTarget
        const overlay = this.overlayTarget

        // Hide menu
        menu.classList.add("hidden")
        menu.classList.add("-translate-x-full")
        menu.classList.remove("translate-x-0")

        // Hide overlay
        overlay.classList.add("hidden")
    }

    // Action for overlay click
    hideOnOverlay() {
        this.hide()
    }
}