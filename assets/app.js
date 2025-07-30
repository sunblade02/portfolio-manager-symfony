import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

import $ from 'jquery';

$(document).ready(function() {
  // load the theme on page load
  const localTheme = localStorage.getItem('theme');
  if (localTheme !== null) {
    setTheme(localTheme);
  } else {
    updateDataTheme('system');
  }

  // update the html tag to load the theme
  function updateDataTheme(theme) {
    if (theme === 'system') {
      $('html').removeAttr('data-theme');
    } else {
      $('html').attr('data-theme', theme);
    }
  }

  // set the theme, save it in local storage and load it
  $('.set-theme').click(function() {
    setTheme($(this).data('theme'));
  });

  function setTheme(theme) {
    let themeIcon = 'desktop';
    switch (theme) {
      case 'light':
        themeIcon = 'sun';
        break;
      case 'dark':
        themeIcon = 'moon';
        break;
    }
    $('.current-theme i').attr('class', 'fa fa-' + themeIcon);
    localStorage.setItem('theme', theme);
    updateDataTheme(theme);
  }

  // handle the burger menu display
  $('.navbar-burger').click(function() {
    let target = $('#' + $(this).data('target'));
    if ($(this).hasClass('is-active')) {
      $(this).removeClass('is-active');
      target.removeClass('is-active');
    } else {
      $(this).addClass('is-active');
      target.addClass('is-active');
    }
  });

  // handle the theme menu display
  $('.navbar-item.has-dropdown').click(function() {
    if ($(this).hasClass('is-active')) {
      $(this).removeClass('is-active');
    } else {
      $(this).addClass('is-active');
    }
  });
});