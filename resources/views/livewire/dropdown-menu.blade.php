<div
  x-data="accountMenu()"
  x-init="init"
  @click.outside="close"
  class="relative inline-block text-left"
>
  <!-- Trigger Button -->
  <button
    @click="toggle"
    x-ref="trigger"
    class="flex items-center space-x-2 px-4 py-2 bg-[--color-input] text-[--color-foreground] border border-[--color-border] rounded-md"
  >
    <span>{{ auth()->user()->fullName() }}</span>
    <svg class="w-4 h-4 text-[--color-muted-foreground]" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
  </button>

  <!-- Dropdown Menu -->
  <div
    x-show="open"
    x-transition
    :class="placement === 'top' ? 'bottom-full mb-2' : 'top-full mt-2'"
    class="absolute z-10 w-48 bg-[--color-card] text-[--color-card-foreground] border border-[--color-border] rounded-md shadow-lg"
  >
    <ul class="py-1">
      {{-- <li>
        <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-[--color-muted]">Profile</a>
      </li>
      <li>
        <a href="{{ route('settings.profile') }}" class="block px-4 py-2 hover:bg-[--color-muted]">Settings</a>
      </li> --}}
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 hover:bg-[--color-destructive] text-[--color-destructive-foreground]">
            Logout
          </button>
        </form>
      </li>
    </ul>
  </div>
</div>

<script>
function accountMenu() {
  return {
    open: false,
    placement: 'bottom',
    toggle() {
      this.open = !this.open;
      if (this.open) this.calculatePlacement();
    },
    close() {
      this.open = false;
    },
    init() {
      this.calculatePlacement();
      window.addEventListener('resize', () => this.calculatePlacement());
    },
    calculatePlacement() {
      this.$nextTick(() => {
        const rect = this.$refs.trigger.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;
        this.placement = spaceBelow < 200 && spaceAbove > spaceBelow ? 'top' : 'bottom';
      });
    }
  }
}
</script>
