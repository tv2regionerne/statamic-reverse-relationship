import ReverseRelationship from './components/fieldtypes/ReverseRelationship.vue';

Statamic.booting(() => {
  Statamic.component(
    'reverse_relationship-fieldtype',
    ReverseRelationship,
  );
});

