# Safari theme audio

Place these files here for the game audio to work:

- **ambient-safari.mp3** — Looping ambient background (savanna / nature). Used when the user enables audio via the HUD toggle.
- **shutter.mp3** — Short camera shutter sound played on project encounter (photography mini-game).

The game engine (`game.js`) looks for `<audio id="ambientAudio">` and `<audio id="shutterAudio">`; both are output by the theme footer with sources pointing to this directory.
