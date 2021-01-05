<div>
    <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th class="w-1/5 text-left py-2 px-3 uppercase font-semibold text-sm">id</th>
                <th class="w-3/5 text-left py-2 px-3 uppercase font-semibold text-sm">Nombre</th>
                <th class="text-left py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach ($subjects as $subject)
                <tr>
                    <td class="w-1/5 text-left py-2 px-3 border-b">{{ $subject->id }}</td>
                    <td class="w-3/5 text-left py-2 px-3 border-b">{{ $subject->name }}</td>
                    <td class="py-2 px-3 border-b">
                        <div class="flex items-center justify-evenly">
                        <a class="hover:bg-blue-200 hover:text-blue-600 rounded-xl p-1" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="1rem" height="1rem">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg></a>
                        <a class="hover:text-red-500" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="1rem" height="1rem">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
