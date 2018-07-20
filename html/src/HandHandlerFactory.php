<?php

namespace PokerAdviser;

/**
 * Factory class to produce poker hands.
 */
class HandHandlerFactory {

  /**
   * Builds a hand instance.
   *
   * @param $hand string
   *   The poker' hand name in lower case.
   *
   * @throws \Exception
   *
   * @return object
   *   A hand instance.
   */
  public static function build($hand) {
    $hand_class = '\\PokerAdviser\\Hand\\' . str_replace(' ', '', ucwords($hand)) . 'Hand';

    if (class_exists($hand_class)) {
      return new $hand_class();
    }
    else {
      throw new \Exception("The class {$hand_class} is not exist.");
    }
  }
}
