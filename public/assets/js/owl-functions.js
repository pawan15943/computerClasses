$('#homeSlider').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    navText: ['<i class="las la-angle-left arrow-left"></i>', '<i class="las la-angle-left arrow-right"></i>'],
    pagination:true,
    responsive: {
        0: {
            items: 1,
            stagePadding: 0,
        },

        768: {
            items: 1,
            stagePadding: 0,
        },
        992: {
            items: 1,
            stagePadding: 0,
        },
        1200: {
            items: 1,
            stagePadding: 0,
        },
        1920: {
            items: 1,
            stagePadding: 0,
        }
    }
})

// function courseSlider() {
//     $(".courses_carousel").html('');
//     $.get("/assets-new/json/customCourse.json", function (data) {
//         var sliderData = data[center];

//         for (var i = 0; i < sliderData.length; i++) {
//             $(".courses_carousel").append(sliderData[i].item)
//         }

//         var courses_slider = $(".courses_carousel");
//         if (courses_slider.length) {
//             courses_slider.owlCarousel({
//                 loop: false,
//                 margin: 30,
//                 items: 4,
//                 autoplay: false,
//                 smartSpeed: 500,
//                 responsiveClass: true,
//                 nav: true,
//                 dots: false,
//                 navText: ['<i class="las la-angle-left"></i>', '<i class="las la-angle-left"></i>'],
//                 responsive: {
//                     0: {
//                         items: 1,
//                         stagePadding: 0,

//                     },

//                     768: {
//                         items: 3,
//                         stagePadding: 0,
//                         margin: 15

//                     },
//                     992: {
//                         items: 4,
//                         stagePadding: 0,
//                     },
//                     1200: {
//                         items: 4,
//                     }
//                 },
//             })
//         }
//     });



// }
// courseSlider();
