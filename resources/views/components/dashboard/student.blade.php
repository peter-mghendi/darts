<div class="grid grid-cols-3 gap-4">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-2">
        <div class="px-4 py-5 sm:px-6 h-full">
            <div class="bg-blue-100 h-full rounded"></div>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4 col-span-3 md:col-span-1">
        <div class="px-4 py-5 sm:px-6">
            @forelse ($subjectRecords as $subject => $record)
                @php
                    $percentage = floor(($record['attendances'] / $record['occurrences']) * 100);
                    $color = $percentage >= 80 ? 'green' : 'red';
                @endphp

                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-{{ $color }}-600 bg-{{ $color }}-200">
                                {{ $subject }}
                            </span>
                        </div>
                        
                        <div class="text-right">
                            <span class="text-xs font-semibold inline-block text-{{ $color }}-600">
                                {{ $percentage }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-{{ $color }}-200">
                        <div style="width: {{ $percentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-{{ $color }}-500"></div>
                    </div>
                </div>
            @empty
                No subjects registered
            @endforelse
        </div>
    </div>
</div>