<template>
    <div class="body mb-5 mt-5">
        <div class="align-middle">
            <section class="list">
                <header>Case Items</header>
                <draggable class="drag-area" :list="caseItems" :options="{animation:200, group:'i_content'}" :element="'article'" @add="onAdd($event)"  @change="update">
                    <article class="card" v-for="item in caseItems" :key="item.iid" :data-id="item.iid">
                        <header>
                            {{ item.i_content }}
                        </header>
                    </article>
                </draggable>   
            </section>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },
        props: ['caseItems'],
        data() {
            return {
                caseItemsNew: this.caseItems
            }
        },
        methods: {
            onAdd(event) {
                let id = event.item.getAttribute('i_case');
                axios.patch('/case/' + id + '/items/add', {
                    items: items
                }).then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                    console.log(error);
                })
            },
            update() {
                this.caseItemsNew.map((item, index) => {
                    item.order = index + 1;
                });

                axios.put('/case/' + id + '/items/updateAll', {
                    items: items
                }).then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                    console.log(error);
                })
            }

        }
    }
</script>

<style>
    .list {
      background-color: #26004d;
      border-radius: 3px;
      margin: 5px 5px;
      padding: 10px;
      width: 100%;
    }
    .list>header {
      font-weight: bold;
      color: white;
      text-align: center;
      font-size: 20px;
      line-height: 28px;
      cursor: grab;
    }
    .list article {
      border-radius: 3px;
      margin-top: 10px;
    }

    .list .card {
      background-color: #FFF;
      border-bottom: 1px solid #CCC;
      padding: 15px 10px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bolder;
    }
    .list .card:hover {
      background-color: #F0F0F0;
    }
    .drag-area{
     min-height: 10px;  
    }
</style>