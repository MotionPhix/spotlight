<div>
  <label class="text-gray-500">
    {{ $label }}
  </label>
  <div class="relative">
    <button
      wire:click="toggle"
      class="w-full flex items-center h-12 bg-white border rounded-lg px-2"
      >
    @if ($selected !== null)
      {{ $items[$selected] }}
    @else
      Choose...
    @endif
    </button>
    @if ($open)
      <ul
        class="bg-white absolute mt-1 z-10 border rounded-lg w-full">
        @foreach($items as $item)
          <li
            wire:click="select('{{ item }}')"
            @class([
                'px-3 py-2 cursor-pointer',
                'bg-blue-500 text-white' => $selected === $loop->index,
                'hover:bg-blue-400 hover:text-white',
            ])>
            {{ $item }}
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>
