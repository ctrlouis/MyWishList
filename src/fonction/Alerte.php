<?php

namespace wishlist\fonction;


class Alerte {

	public static function set($name_session) {
		$_SESSION['alerte'] = $name_session;
	}

	public static function getSuccesAlert($name_session, $texte) {
		if (SELF::isAlert($name_session))
			echo '
			<div class="callout success" data-closable>
				<p>' . $texte . '</p>
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>';
			SELF::clear();
	}

	public static function getWarningAlert($name_session, $texte) {
		if (SELF::isAlert($name_session)) {
			echo '
			<div class="callout warning " data-closable>
				<p>' . $texte . '</p>
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>';
			SELF::clear();
		}
	}

	public static function getInfoAlert($name_session, $texte) {
		if (SELF::isAlert($name_session)) {
			echo '
			<div class="callout primary" data-closable>
				<p>' . $texte . '</p>
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>';
			SELF::clear();
		}
	}

	public static function getErrorAlert($name_session, $texte) {
		if (SELF::isAlert($name_session)) {
			echo '
			<div class="callout alert" data-closable>
				<p>' . $texte . '</p>
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>';
			SELF::clear();
		}
	}

	public static function getSecondaryAlert($name_session, $texte) {
		if (SELF::isAlert($name_session)) {
			echo '
			<div class="callout secondary" data-closable>
				<p>' . $texte . '</p>
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				</button>
			</div>';
			SELF::clear();
		}
	}

	public static function isAlert($name_session) {
		return isset($_SESSION['alerte']) && $_SESSION['alerte'] == $name_session;
	}

	public static function clear() {
		$_SESSION['alerte'] = null;
	}

}
