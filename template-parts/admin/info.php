<?php

function number($number, $type = "lite") {
  $color = $type === "lite" ? "text-gray-500" : "text-green-700";
  return "<span class='$color'>$number</span>";
}

?>


<div class="selleradise-page-admin--information">
  <h1 class="text-3xl">
    Thank You For Installing Selleradise.
  </h1>

  <ul>
    <li>
      <a 
        href="https://docs.selleradise.com/docs/getting-started/import-demo-content"
        target="_blank"
        rel="noreferrer"
        class="text-lg font-medium no-underline">
        How to import demo content?
      </a>
    </li>
    <li>
      <a 
        href="https://docs.selleradise.com/docs/getting-started/setup-homepage"
        target="_blank"
        rel="noreferrer"
        class="text-lg font-medium no-underline">
        How to setup homepage like demo?
      </a>
    </li>
  
  </ul>

  <h2 class="mt-10 mb-0 text-2xl">You are currently using the LITE version of the theme.</h2>

  <p> Here is a quick comparison between LITE and FULL version.</p>

  <table class="table-auto w-1/2">
    <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50">
      <tr>
        <th class="p-3 whitespace-nowrap">
            <div class="font-semibold text-left">Feature</div>
        </th>
        <th class="p-3 whitespace-nowrap">
            <div class="font-semibold text-center">Lite</div>
        </th>
        <th class="p-3 whitespace-nowrap">
            <div class="font-semibold text-center">Full</div>
        </th>
      </tr>
    </thead>
    <tbody class="text-sm divide-y divide-gray-100 whitespace-nowrap">
      <tr>
        <td class="px-2 py-1">
            <p class="font-bold text-gray-600 text-left">Quick Search Module</p>
        </td>
        <td class="px-2 py-1">
            <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Dark Mode</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Shop Filters</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Custom Colors</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
      </tr>
       <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Custom Fonts</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Yes</p>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Elementor Widgets</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-500 text-center">Limited</p>
        </td>
        <td class="px-2 py-1">
          <p class="font-bold text-green-700 text-center">Complete</p>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Headers</p>
        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(1) ?>

        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(7, "full") ?>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1">
          <p class="font-bold text-gray-600 text-left">Product Cards</p>
        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(1) ?>
        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(5, "full") ?>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1 text-center">
          <p class="font-bold text-gray-600 text-left">Category Cards</p>
        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(1) ?>

        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(6, "full") ?>
        </td>
      </tr>
      <tr>
        <td class="px-2 py-1 text-center">
          <p class="font-bold text-gray-600 text-left">Post Cards</p>
        </td>
        <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(1) ?>

        </td>
       <td class="px-2 py-1 text-center font-semibold">
          <?php echo number(5, "full") ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td class="text-center">
          <a 
            href="https://redoxbird.com/product/selleradise"
            target="_black"
            rel="noreferrer"
            class="
                mt-2 
                inline-block 
                font-semibold 
                bg-[#2271b1] 
                text-sm 
                text-white 
                hover:text-white 
                focus:text-white 
                active:text-white 
                px-5 
                py-3 
                rounded-full 
                no-underline"
            >
            Get the Full Version
          </a>
        </td>
      </tr>
    </tbody>
  </table>

  <p>If you like the theme please consider buying the full version to help support the project.</p>
</div>

<?php