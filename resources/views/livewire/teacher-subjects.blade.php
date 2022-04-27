<div class="flex">
  {{-- split screen, in left panel list careers, in right panel list subjects --}}
  <div class="w-1/2 border-2 border-black">
    Careers
    @foreach ($careers as $career)
      <div class="flex items-center justify-between mb-4">
        <div class="w-1/2">{{ $career->id }}</div>
        <div class="w-1/2">{{ $career->name }}</div>
      </div>
    @endforeach
  </div>
  <div class="w-1/2 border-2 border-red-700">
    Subjects
    @foreach ($subjects as $subject)
      <div class="flex items-center justify-between mb-4">
        <div class="w-1/2">{{ $subject->id }}</div>
        <div class="w-1/2">{{ $subject->name }}</div>
      </div>
    @endforeach
  </div>
</div>
