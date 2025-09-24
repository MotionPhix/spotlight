// Stimulus.js Setup
import { Application } from "@hotwired/stimulus"

// Import controllers
import MenuController from "./controllers/menu_controller"
import DropdownController from "./controllers/dropdown_controller"
import SearchController from "./controllers/search_controller"
import ThemeController from "./controllers/theme_controller"

// Start Stimulus application
const application = Application.start()

// Register controllers
application.register("menu", MenuController)
application.register("dropdown", DropdownController)
application.register("search", SearchController)
application.register("theme", ThemeController)