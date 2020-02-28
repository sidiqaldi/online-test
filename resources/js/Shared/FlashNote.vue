<template>
    <div>
        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="$page.status">
        <strong>Success!</strong>
        {{ $page.status }}.
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    </div>
</template>