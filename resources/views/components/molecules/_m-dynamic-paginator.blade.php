<nav class="m-paginator" data-behavior="dynamicFilterPagination" data-pagination-limit={{$limit}}>
    <ul class="m-paginator__prev-next">
      <li>
        <a href="#" class="f-buttons">
          <span>Next</span>
          <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
        </a>
      </li>
      <li>
        <span class="f-buttons">
          <span>Previous</span>
          <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
        </span>
      </li>
    </ul>
    <ul class="m-paginator__pages">
      <!-- Page buttons will be generated dynamically -->
    </ul>
    <p class="m-paginator__current-page f-buttons">Page 1</p>
  </nav>