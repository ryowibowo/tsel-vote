<table>
    <thead>
        <tr>
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>Pilihan Kategori FIXED</th>
            <th>Pilihan Kategori MOBILE</th>
            <th>Waktu Vote</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($voters as $voter)
            {{-- PINDAHIN BLOK PHP KE SINI, DI PALING ATAS LOOP --}}
            @php
                $fixedVotes = $voter->votes
                    ->filter(function ($vote) {
                        return optional($vote->product->category)->name == 'FIXED';
                    })
                    ->values();

                $mobileVotes = $voter->votes
                    ->filter(function ($vote) {
                        return optional($vote->product->category)->name == 'MOBILE';
                    })
                    ->values();
            @endphp

            <tr>
                <td rowspan="5">{{ $voter->nik }}</td>
                <td rowspan="5">{{ $voter->full_name }}</td>

                <td>{{ optional($fixedVotes->get(0))->product->name ?? '' }}</td>
                <td>{{ optional($mobileVotes->get(0))->product->name ?? '' }}</td>
                <td rowspan="5">{{ $voter->created_at->format('d-m-Y H:i') }}</td>
            </tr>

            {{-- Looping untuk 4 sisa pilihan --}}
            @for ($i = 1; $i < 5; $i++)
                <tr>
                    <td>{{ optional($fixedVotes->get($i))->product->name ?? '' }}</td>
                    <td>{{ optional($mobileVotes->get($i))->product->name ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
