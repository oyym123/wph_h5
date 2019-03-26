<template>
<div class="row clearfix">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Home</a></li>
        <li role="presentation"><a href="#">Profile</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <div class="col-md-12 column content">
        <div class="col-md-7 col-md-offset-1 column">
            <router-view></router-view>
        </div>
    </div>
</div>
</template>