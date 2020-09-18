@extends('public.layout')

@section('content')
    <x-section>
        <div class="grid items-center gap-20 lg:grid-cols-2">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <img src="{{ asset('assets/images/hero.png') }}" class="w-full" alt="">
            </div>

            <div class="w-full mx-auto text-center lg:text-left">
                <x-h1 text="Bine ai venit!" class="text-teal-400" />

                <p class="max-w-md mx-auto mt-3 md:mt-5 md:max-w-3xl">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sed netus blandit mi non nunc. Ipsum aliquam fringilla sagittis, quis rutrum. Arcu imperdiet sem tellus accumsan urna orci. Ridiculus facilisis curabitur bibendum ultricies lacus, sollicitudin id massa augue. Consequat ullamcorper semper nisl tristique habitant eu et ac. Auctor magna tellus cursus viverra tortor. Porttitor consequat.
                </p>
            </div>
        </div>
    </x-section>

    <x-section>
        <x-h1 text="Platforma donatorilor" class="mb-6 text-center" />

        <div class="grid gap-16 text-center md:grid-cols-3">
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-yellow-300 rounded-full">
                    <x-ri-bar-chart-grouped-line />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Date agregate</h2>
                <p>Beatae odio architecto provident qui dolorem et voluptatem harum. Suscipit deserunt ut eveniet est facilis et debitis consequatur quod. Ducimus vero a perferendis non facere molestias hic. Eum sequi cumque repudiandae et eum.</p>
            </div>
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-teal-300 rounded-full">
                    <x-ri-macbook-line />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Dashboard intuitiv</h2>
                <p>Quis est ducimus excepturi maxime aut impedit praesentium quo. Dolorum sit est repellendus quos accusantium. Eum expedita qui accusamus alias assumenda molestiae nesciunt sit et. Voluptate fugit fuga.</p>
            </div>
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-yellow-300 rounded-full">
                    <x-ri-pie-chart-2-fill />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Date agregate</h2>
                <p>Minima ad deleniti sunt odit sed exercitationem aliquam consectetur. Aut esse qui molestiae enim. Dolorum cupiditate perferendis id corrupti sequi dolorem sit corrupti error. Non porro asperiores sed quia qui.</p>
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="grid items-center gap-20 lg:grid-cols-2">
            <div class="w-full mx-auto text-center lg:text-left">
                <x-h1 text="Vino alături de noi" class="text-teal-400" />

                <p class="max-w-md mx-auto mt-3 md:mt-5 md:max-w-3xl">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sed netus blandit mi non nunc. Ipsum aliquam fringilla sagittis, quis rutrum. Arcu imperdiet sem tellus accumsan urna orci. Ridiculus facilisis curabitur bibendum ultricies lacus, sollicitudin id massa augue. Consequat ullamcorper semper nisl tristique habitant eu et ac. Auctor magna tellus cursus viverra tortor. Porttitor consequat.
                </p>
            </div>

            <div class="max-w-lg mx-auto lg:max-w-none">
                <img src="{{ asset('assets/images/hero.png') }}" class="w-full" alt="">
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="mx-auto mb-12 text-center">
            <x-h1 text="Rezultate" class="mb-6 text-center text-teal-300" />

            <p>Hic perspiciatis rerum accusamus qui similique labore animi quisquam. Iste labore consectetur sed atque minus tenetur aut. Dolorum animi similique nihil eum aut voluptas. Incidunt ipsa neque doloribus aut cumque. Adipisci excepturi fuga aspernatur qui voluptas quia eos saepe sint. Modi quisquam temporibus. Omnis ullam cumque. Rem voluptas et sed nihil saepe debitis quidem. Qui repellat temporibus soluta ducimus provident.</p>
        </div>

        <div class="grid gap-16 text-center md:grid-cols-3">
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-yellow-300 rounded-full">
                    <x-ri-bar-chart-grouped-line />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Date agregate</h2>
                <p>Beatae odio architecto provident qui dolorem et voluptatem harum. Suscipit deserunt ut eveniet est facilis et debitis consequatur quod. Ducimus vero a perferendis non facere molestias hic. Eum sequi cumque repudiandae et eum.</p>
            </div>
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-teal-300 rounded-full">
                    <x-ri-macbook-line />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Dashboard intuitiv</h2>
                <p>Quis est ducimus excepturi maxime aut impedit praesentium quo. Dolorum sit est repellendus quos accusantium. Eum expedita qui accusamus alias assumenda molestiae nesciunt sit et. Voluptate fugit fuga.</p>
            </div>
            <div>
                <div class="w-20 p-6 mx-auto mb-5 bg-yellow-300 rounded-full">
                    <x-ri-pie-chart-2-fill />
                </div>

                <h2 class="mb-3 text-lg font-semibold">Date agregate</h2>
                <p>Minima ad deleniti sunt odit sed exercitationem aliquam consectetur. Aut esse qui molestiae enim. Dolorum cupiditate perferendis id corrupti sequi dolorem sit corrupti error. Non porro asperiores sed quia qui.</p>
            </div>
        </div>
    </x-section>
@endsection
