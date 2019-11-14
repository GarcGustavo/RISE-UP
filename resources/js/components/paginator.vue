<template>
  <!-- skip previous label disable if page < 5 -->
  <ul v-if="pager.pages && pager.pages.length" class="pagination" :style="ul_styles">
    <li class="page-item skip-prev" :class="{'disabled': pager.currentPage < 5}" :style="li_styles">
      <!-- if pressed set page to current - 5 -->
      <a
        class="page-link"
        @click="setPage(pager.currentPage - 5)"
        :style="a_styles"
      >{{labels.skip_prev}}</a>
    </li>
    <!-- skip to first page label -->
    <li class="page-item first" :class="{'disabled': pager.currentPage === 1}" :style="li_styles">
      <a class="page-link" @click="setPage(1)" :style="a_styles">{{labels.first}}</a>
    </li>
    <!-- previous label -->
    <li
      class="page-item previous"
      :class="{'disabled': pager.currentPage === 1}"
      :style="li_styles"
    >
      <a
        class="page-link"
        @click="setPage(pager.currentPage - 1)"
        :style="a_styles"
      >{{labels.previous}}</a>
    </li>
    <!-- list of pages -->
    <li
      v-for="page in pager.pages"
      :key="page"
      class="page-item page-number"
      :class="{'active': pager.currentPage === page}"
      :style="li_styles"
    >
      <!-- make them clickable -->
      <a class="page-link" @click="setPage(page)" :style="a_styles">{{page}}</a>
    </li>
    <!-- next label -->
    <li
      class="page-item next"
      :class="{'disabled': pager.currentPage === pager.totalPages}"
      :style="li_styles"
    >
      <a class="page-link" @click="setPage(pager.currentPage + 1)" :style="a_styles">{{labels.next}}</a>
    </li>
    <!-- skip to last page label -->
    <li
      class="page-item last"
      :class="{'disabled': pager.currentPage === pager.totalPages}"
      :style="li_styles"
    >
      <a class="page-link" @click="setPage(pager.totalPages)" :style="a_styles">{{labels.last}}</a>
    </li>
    <!-- skip next 5 label set page to current + 5 -->
    <li
      class="page-item skip-next"
      :class="{'disabled': pager.currentPage > pager.totalPages - 5}"
      :style="li_styles"
    >
      <a
        class="page-link"
        @click="setPage(pager.currentPage + 5)"
        :style="a_styles"
      >{{labels.skip_next}}</a>
    </li>
  </ul>
</template>

<script>
import paginate from "jw-paginate";
const default_labels = {
  //labels for options
  first: "First",
  last: "Last",
  previous: "<",
  next: ">",
  skip_prev: "<<",
  skip_next: ">>"
};
const default_styles = {
  //paginator default style
  ul: {
    margin: 0,
    padding: 0,
    display: "inline-block"
  },
  li: {
    listStyle: "none",
    display: "inline",
    textAlign: "center"
  },
  a: {
    border: 0,
    cursor: "pointer",
    padding: "6px 12px",
    display: "block",
    float: "left"
  }
};
export default {
  props: {
    items: {
      //array of items to be paged
      type: Array,
      required: true
    },
    initial_page: {
      //set first page
      type: Number,
      default: 1
    },
    page_size: {
      //set number of items per page
      type: Number,
      default: 10
    },
    max_pages: {
      //number of pages to be shown between labels(<1,2,3,4,5>)
      type: Number,
      default: 5
    },
    labels: {
      //default options labels
      type: Object,
      default: () => default_labels
    },
    styles: {
      //custom style(no custom style has been used)
      type: Object
    },
    disable_default_styles: {
      //set default style
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      pager: {},
      ul_styles: {},
      li_styles: {},
      a_styles: {}
    };
  },
  created() {
    if (!this.$listeners.changePage) {
      throw 'Missing required event listener: "changePage"';
    }
    // set default styles unless disabled
    if (!this.disable_default_styles) {
      this.ul_styles = default_styles.ul;
      this.li_styles = default_styles.li;
      this.a_styles = default_styles.a;
    }
    // merge custom styles with default styles
    if (this.styles) {
      this.ul_styles = { ...this.ul_styles, ...this.styles.ul };
      this.li_styles = { ...this.li_styles, ...this.styles.li };
      this.a_styles = { ...this.a_styles, ...this.styles.a };
    }
    // set page if items array isn't empty
    if (this.items && this.items.length) {
      this.setPage(this.initial_page);
    }
  },
  methods: {
    setPage(page) {
      const { items, page_size, max_pages } = this;
      // get new pager object for specified page
      const pager = paginate(items.length, page, page_size, max_pages);
      // get new page of items from items array
      const page_of_items = items.slice(pager.startIndex, pager.endIndex + 1);
      // update pager
      this.pager = pager;
      // emit change page event to parent component
      this.$emit("changePage", page_of_items);
    }
  }
};
</script>
