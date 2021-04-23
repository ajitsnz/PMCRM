@extends('layouts.front.app')
@section('title')
    Article Search Screen
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <h5 class="my-0 text-center">Search Articles</h5>
                <div class="form-group w-75 d-flex mx-auto mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Article..." aria-label="">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary"><i class="fas fa-search text-white"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <h5 class="my-2">Title goes here...</h5>
                <hr class="my-1">
                <p class="text-justify">
                    Consectetur sequi tempore suscipit in doloremque aut. Assumenda maxime ipsam molestias porro. Aut
                    tenetur repellendus non quisquam consequatur alias.
                    Qui et laudantium commodi ut. Praesentium et velit at et eius. Nam est magni tempora eos maiores
                    voluptatem. Fuga molestiae eum in corrupti. Nulla dolores aspernatur nihil quaerat deserunt
                    quisquam. Dolorem ex voluptatibus recusandae qui dolores numquam. Nemo nulla suscipit aut saepe.
                    Recusandae ducimus tempora autem vel id magni. Accusamus sit aut sit quo voluptas porro. Nobis nihil
                    dolores aperiam tempora. Quia voluptatibus est quidem dignissimos dolor. Dolorem repellendus
                    cupiditate et facere veniam. Unde molestiae dolores et tempora explicabo neque. Numquam natus culpa
                    aut ut. Praesentium voluptatem itaque accusantium est eos excepturi eligendi.
                    Asperiores repudiandae quia sed. Esse totam sed nesciunt dolores excepturi eos molestiae. Incidunt
                    ratione quo nemo tempora asperiores repellendus voluptatem. Numquam ducimus eos iure porro. Vel
                    molestias voluptatum repudiandae fugiat non. Excepturi voluptatem sed animi in eaque et nesciunt.
                    Eligendi libero quis et laborum non. Numquam voluptates pariatur esse ad ut ab aut. Amet neque quasi
                    molestias et nulla. Adipisci deleniti sed nostrum molestias. Hic ea ullam tempora nemo consequatur
                    est. Non voluptatem non in iusto fugit sequi rerum nobis.
                    Enim culpa qui at deserunt ea. Natus non itaque nemo dolorem. Delectus in ea inventore velit
                    cupiditate eius nobis. Ut deleniti ut omnis unde quos voluptatem.
                </p>
                <hr class="my-1">
                <h5 class="my-3">Did you find this article useful?</h5>
                <a href="#" class="btn btn-sm btn-icon icon-left btn-success"><i class="fas fa-check"></i> Yes</a>
                <a href="#" class="btn btn-sm btn-icon icon-left btn-danger"><i class="fas fa-times"></i> No</a>
            </div>
            <div class="col-md-4 relatedArticles">
                <h5 class="my-2">Related Articles</h5>
                <hr class="my-1">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 bg-transparent">
                        <h6 class="my-0">
                            <a href="javascript:void(0)" class="font-weight-bold text-decoration-none">
                                This question the Dodo had paused as.
                            </a>
                        </h6>
                        <p class="py-0 text-justify">
                            Qui inventore aperiam et porro. Quis est voluptatum sequi voluptatem autem aliquid totam
                            optio. Consequuntur id rerum praesentium sed reiciendis ea.
                        </p>
                    </li>
                    <li class="list-group-item px-0 bg-transparent">
                        <h6 class="my-0">
                            <a href="javascript:void(0)" class="font-weight-bold text-decoration-none">
                                This question the Dodo had paused as.
                            </a>
                        </h6>
                        <p class="py-0 text-justify">
                            Qui inventore aperiam et porro. Quis est voluptatum sequi voluptatem autem aliquid totam
                            optio. Consequuntur id rerum praesentium sed reiciendis ea.
                        </p>
                    </li>
                    <li class="list-group-item px-0 bg-transparent">
                        <h6 class="my-0">
                            <a href="javascript:void(0)" class="font-weight-bold text-decoration-none">
                                This question the Dodo had paused as.
                            </a>
                        </h6>
                        <p class="py-0 text-justify">
                            Qui inventore aperiam et porro. Quis est voluptatum sequi voluptatem autem aliquid totam
                            optio. Consequuntur id rerum praesentium sed reiciendis ea.
                        </p>
                    </li>
                    <li class="list-group-item px-0 bg-transparent">
                        <h6 class="my-0">
                            <a href="javascript:void(0)" class="font-weight-bold text-decoration-none">
                                This question the Dodo had paused as.
                            </a>
                        </h6>
                        <p class="py-0 text-justify">
                            Qui inventore aperiam et porro. Quis est voluptatum sequi voluptatem autem aliquid totam
                            optio. Consequuntur id rerum praesentium sed reiciendis ea.
                        </p>
                    </li>
                    <li class="list-group-item px-0 bg-transparent">
                        <h6 class="my-0">
                            <a href="javascript:void(0)" class="font-weight-bold text-decoration-none">
                                This question the Dodo had paused as.
                            </a>
                        </h6>
                        <p class="py-0 text-justify">
                            Qui inventore aperiam et porro. Quis est voluptatum sequi voluptatem autem aliquid totam
                            optio. Consequuntur id rerum praesentium sed reiciendis ea.
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
