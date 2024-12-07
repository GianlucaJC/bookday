<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <?php
        $id = Auth::id();
        $inf=DB::table('users')->select('isadmin')->where('id','=',$id)->first();
        $isadmin=0;
        if($inf) $isadmin=$inf->isadmin;

    ?>

    @if ($isadmin==0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <button type="button" class="btn btn-primary">Elenco Libri</button>
                    </div>
                </div>
            </div>
        </div>
    @endif   
</x-app-layout>
