// Single source of truth for the fixed content used by Percy snapshots.
// Keep these pointing at stable, evergreen content so visual diffs reflect
// real changes rather than incidental content churn.
module.exports = {
  // Verified against local dev: resolves to "Starry Night and the
  // Astronauts" (canonical URL /artworks/129884/starry-night-and-the-astronauts).
  artworkId: 21023,

  // Created by database/seeders/PercyFixtureSeeder.php; verified locally
  // that Twill's slug behavior derives this slug from the fixture title.
  genericPageSlug: 'percy-fixture-page',
};
