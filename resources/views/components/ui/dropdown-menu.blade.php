<div
  x-data="dropdownMenu()"
  x-init="init"
  @click.outside="close"
  class="relative inline-block text-left"
>
  <!-- Trigger -->
  <button
    @click="toggle"
    x-ref="trigger"
    class="flex items-center space-x-2 bg-[--color-input] text-[--color-foreground] rounded-md focus:outline-none"
    @keydown.arrow-down="next()"
    @keydown.arrow-up="previous()"
    @keydown.enter.prevent="select()"
    @keydown.escape="close()"
  >
    @if (isset($trigger))
    {!! $trigger !!}
    @else
    <img src="/vendor/bladewind/icons/solid/ellipsis-horizontal.svg" class="w-8 h-8 rounded-full" alt="User Avatar">
    @endif
  </button>

  <!-- Dropdown -->
  <div
    x-show="open"
    x-transition
    :class="placement === 'top' ? 'bottom-full mb-2' : 'top-full mt-2'"
    class="absolute right-0 z-10 w-36 bg-white text-[--color-card-foreground] border border-[--color-border] rounded-md shadow-lg">
    <div class="py-1">
      {{ $slot }}
    </div>
  </div>
</div>

<script>
function dropdownMenu() {
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
