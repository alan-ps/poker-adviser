<?php

namespace PokerAdviser\Hand;

/**
 * Base class for Poker Adviser hand implementations.
 */
abstract class Hand {

  /**
   * The own cards.
   *
   * @var array
   */
  protected $cards_own;

  /**
   * The cards from the desk.
   *
   * @var array
   */
  protected $cards_desk;

  /**
   * The own + desk cards.
   *
   * @var array
   */
  protected $cards_all;

  /**
   * Helper method to calculate own/possible hand.
   *
   * @return \stdClass
   *   The hand object.
   */
  abstract public function calculate();

  /**
   * Initialize a new hand.
   *
   * @return \stdClass
   *   The hand object.
   */
  public function init() {
    $hand = new \stdClass();
    $hand->own = [];
    $hand->possible = [];
    $hand->reserved = [];

    return $hand;
  }

  /**
   * Sets the cards for calculation.
   *
   * @param $own array
   *   The own cards.
   *
   * @param $desk array
   *   The cards from the desk.
   */
  public function setCards($own, $desk) {
    $this->cards_own = $own;
    $this->cards_desk = $desk;
    $this->cards_all = array_merge($this->cards_own, $this->cards_desk);
  }

  /**
   * Helper method to get card code by its suite and rank.
   *
   * @param $suite int
   *   The suite of the card.
   *
   * @param $rank int
   *   The rank of the card.
   *
   * @return int
   *   The card code.
   */
  public function getCardCode($suite, $rank) {
    $card = $rank >= 10 ? "{$suite}{$rank}0" : "{$suite}0{$rank}0";
    return (int) $card;
  }

  /**
   * Helper method to check if card is own.
   *
   * @param $card
   *   The card for checking.
   *
   * @return bool
   *   TRUE if card is own, otherwise - FALSE.
   */
  public function isOwn($card) {
    return in_array($card, $this->cards_own);
  }
}
