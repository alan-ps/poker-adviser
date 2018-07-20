<?php

namespace PokerAdviser\Hand;

/**
 * The Straight Flush hand handler.
 */
class StraightFlushHand extends Hand {

  /**
   * {@inheritdoc}
   */
  public function calculate() {
    $hand = $this->init();

    // Bypass all cards (ranks and suites) to make up own/possible combinations.
    for ($rank = 14; $rank >= 2; $rank--) {
      for ($suite = 4; $suite >= 1; $suite--) {
        $card = $this->getCardCode($suite, $rank);

        // The card is active and it can be taken in order to create either own
        // or possible hand.
        if (in_array($card, $this->cards_own)) {
          $hand->own[$suite] = $this->getConnected($hand->own[$suite] ?: [], $rank);

          if (count($hand->possible[$suite]) < 5) {
            $hand->possible[$suite] = !$this->isOwn($card) ? $this->getConnected($hand->possible[$suite] ?: [], $rank) : [];
          }
        }
        // The card is not an active and can be taken in order to create
        // possible hand only.
        elseif (count($hand->possible[$suite]) < 5) {
          $hand->reserved[$suite][] = $rank;
          $hand->possible[$suite][] = $rank;

          // We can reserve two cards only, in order to create possible hand.
          // Split an array and try to create another combination, if a limit
          // has been exceeded.
          if (count($hand->reserved[$suite]) > 2) {
            $shifted = array_shift($hand->reserved[$suite]);
            $hand->possible[$suite] = array_filter($hand->possible[$suite], function($v) use ($shifted) {
              return $v < $shifted;
            }, ARRAY_FILTER_USE_BOTH);
          }
        }
      }
    }

    return $this->handle($hand);
  }

  /**
   * Helper method to get connected ranks.
   *
   * @param $connected_ranks array
   *   The connected ranks for comparison with $rank.
   *
   * @param $rank int
   *   The rank to check.
   *
   * @return array
   *   The connected ranks with $rank if it can be connected.
   */
  public function getConnected($connected_ranks, $rank) {
    // The hand is completed, just return result.
    if (count($connected_ranks) >= 5) {
      return $connected_ranks;
    }

    // Add rank to a connected array if it possible, otherwise — create new
    // array to store connected ranks.
    if (($largest = end($connected_ranks)) && $rank + 1 == $largest) {
      $connected_ranks[] = $rank;
    }
    else {
      $connected_ranks = [$rank];
    }

    return $connected_ranks;
  }

  /**
   * Helper method to handle a hand.
   *
   * @param \stdClass $hand
   *   The hand object.
   */
  public function handle(\stdClass $hand) {
    // @todo
  }
}
